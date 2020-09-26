<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController as Controller;

class UserController extends Controller
{
    public function getIndex() {
        $data = $this->model::get();
        
        $array = [
            'data' => $data
        ];

        return view('admin.pages.users.index', $array);
    }

    public function getDetail($id) {
        $data = $this->model::all();
        
        $array = [
            'data' => $data
        ];

        return view('admin.pages.users.index', $array);
    }

    public function getEdit($id) {
        $data = $this->model::all();
        
        $array = [
            'data' => $data
        ];

        return view('admin.pages.users.index', $array);
    }
}
