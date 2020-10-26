<?php

namespace App\Http\Controllers\Api;

class RoleController extends BaseController
{
    protected $model = 'Spatie\Permission\Models\Role';
  
    protected $validation = [
      'name' => 'string|required'
    ];
}