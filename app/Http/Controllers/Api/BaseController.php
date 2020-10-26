<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UnprocessEntityException;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use App\Exports\GeneralExport;
use App\Imports\GeneralImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\BaseResource;
use Hashids\Hashids;

class BaseController extends Controller
{
    protected $module;

    protected $model;

    protected $validation;

    protected $hashids;

    public function __construct() {
        $this->hashids = new Hashids(config('app.hash-code'), config('app.hash-length')); // all lowercase
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = $this->checkAuth('.read');
        
        if ($auth->status() != 200) return $auth; 

        $requestQuery = request()->query();

        $validation = Validator::make($requestQuery, [
          'page' => 'integer|min:1',
          'limit' => 'integer|min:1',
          'order-by' => 'required_with:sort-by|in:asc,desc',
          'min' => 'regex:/^\d+(\.\d{1,2})?$/',
          'max' => 'regex:/^\d+(\.\d{1,2})?$/'
        ]);
    
        if($validation->fails()) {
            return response()->json([
                "message" => $validation->messages()
            ], 422);
        }

        $limit = $requestQuery['limit'] ?? 25;
        
        $model = new $this->model();

        $column = $model->getConnection()
                        ->getSchemaBuilder()
                        ->getColumnListing(
                            $model->getTable()
                        );

        $relation = $model->getAllRelation();

        $with = [];

        if (isset($requestQuery['include'])) {
            $include = explode(",", $requestQuery['include']);

            foreach ($include as $item) {
                if(in_array($item,$relation)) {
                    array_push($with, $item);
                }
            }
        }
        
        $data = $model::with($with);

        if (isset($requestQuery['filters'])) {
            foreach($requestQuery['filters'] as $key => $value) {
                $filters = explode(",", $value);
                
                if (in_array($key, $column)) {
                    foreach ($filters as $item) {
                        $data = $data->where($key, 'like', "%".$item."%");
                    }
                }
            }
        }

        if(isset($requestQuery['sort-by'])) {
            if (in_array($requestQuery['sort-by'], $column)) {
                $data = $data->orderBy($requestQuery['sort-by'], $requestQuery['order-by']);
            }
        }
        
        $data = $data->paginate($limit);
    
        return BaseResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = $this->checkAuth('.create');
        
        if ($auth->status() != 200) return $auth; 

        $requestJson = $request->json()->all();

        if (isset($this->validation)) {
            $validation = Validator::make($requestJson, $this->validation);
    
            if($validation->fails()) {
                return response()->json([
                    "message" => $validation->messages()
                ], 422);
            }

            $model = new $this->model();

            try{
                DB::beginTransaction();
    
                $data = $model->create($requestJson);

                DB::commit();
                
                $data = $model::find($data->id);
        
                return response()->json($data);
            } catch (Exception $e) {
              DB::rollback();
        
              throw $e;
            }
        }

        return response()->json([
            "message" => "Validation is error"
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $auth = $this->checkAuth('.read');
        
        if ($auth->status() != 200) return $auth; 
        
        $requestQuery = request()->query();
        
        $model = new $this->model();

        $relation = $model->getAllRelation();

        $with = [];

        if (isset($requestQuery['include'])) {
            $include = explode(",", $requestQuery['include']);

            foreach ($include as $item) {
                if(in_array($item,$relation)) {
                    array_push($with, $item);
                }
            }
        }
        
        $data = $model::with($with)->find($this->hashids->decode($id));

        if(!$data) {
            return response()->json([
                "message" => 'Data Not Found'
            ], 404);
        }
        
        return BaseResource::collection($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $auth = $this->checkAuth('.udpate');
        
        if ($auth->status() != 200) return $auth; 
        
        $requestJson = $request->json()->all();

        if (isset($this->validation)) {
            $validation = Validator::make($requestJson, $this->validation);
    
            if($validation->fails()) {
                return response()->json([
                    "message" => $validation->messages()
                ], 422);
            }

            $model = new $this->model();

            $data = $model->find($this->hashids->decode($id));

            if(!$data) {
                return response()->json([
                    "message" => 'Data Not Found'
                ], 404);
            }

            try{
                DB::beginTransaction();
    
                $data->update($requestJson);

                DB::commit();
        
                return response()->json($data);
            } catch (Exception $e) {
              DB::rollback();
        
              throw $e;
            }
        }

        return response()->json([
            "message" => "Validation is error"
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auth = $this->checkAuth('.delete');
        
        if ($auth->status() != 200) return $auth; 
        
        $model = new $this->model();

        $data = $model->find($this->hashids->decode($id));

        if(!$data) {
            return response()->json([
                "message" => 'Data Not Found'
            ], 404);
        }

        $data->delete();
        
        return response()->json([
            "message" => "Data has been deleted"
        ], 204);
    }

    public function export() 
    {
        $requestQuery = request()->query();

        $column = [];

        if (isset($requestQuery['column'])) {
            $value = explode(",", $requestQuery['column']);

            foreach ($value as $item) {
                if(in_array($item,$relation)) {
                    array_push($column, $item);
                }
            }
        }
        
        return Excel::download(new GeneralExport($this->model, $column, $requestQuery['from'] ?? null, $requestQuery['to'] ?? null), ucfirst(str_replace("_", " ", $model->getTable())).'.xlsx');
    }

    public function import() 
    {
        $validator = Validator::make(request()->all(),[
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try{
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            Excel::import(new GeneralImport($this->model), request()->file('file'));

            DB::commit();
            return response()->json([
                'message' => 'Import file excel success.'
            ], 200);
        } catch(Exception $e){
            DB::rollback();

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function checkAuth($scope) {
        if (request()->bearerToken() && !request()->user()->tokenCan($this->module.$scope)) {
            return response()->json([
                'message' => "Unauthicated, token is not valid or scope is not valid"
            ], 401);
        } else {
            return response()->json(null,200);
        }
    }
}
