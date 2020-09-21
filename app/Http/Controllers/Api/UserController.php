<?php

namespace App\Http\Controllers\Api;

class UserController extends BaseController
{
    protected $module = 'user';

    protected $model = 'App\Models\User';
  
    protected $validation = [
      'name' => 'string|required',
      'email' => 'email|required',
    ];
}