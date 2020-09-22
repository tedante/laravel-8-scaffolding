<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Admin\Services\AuthService;
use App\Exceptions\UnprocessEntityException;

use App\Http\Controllers\Api\AuthController as ApiAuthController;

class AuthController extends ApiAuthController
{
    protected $service;

    public function __construct() {
        $this->service = new AuthService();
    }

    public function loginIndex() {
        return view('admin.login');
    }

    public function loginProccess(Request $request) {
        $json = $request->setJson($request);
        
        try{
            $login = $this->login($request);
          
            $body = $login->getData();

            if($login->status() == 401) throw new UnprocessEntityException($login->getData(), 401);
            
            session([
                'user_id' => $body->user_id,
                'email' => $request->email,
                'access_token' => $body->access_token,
                'email_verified_at' => $body->email_verified_at,
                'role' => $body->role,
                'expires_at' => $body->expires_at
            ]);
            
        
        
            return redirect()->route('admin.dashboard');
        } catch(UnprocessEntityException $e) {
            $message = $e->getMessage();
            
            return redirect()->route('admin.login')->with('errors', $message->message);
        }
    }
}