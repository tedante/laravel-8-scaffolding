<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class DashboardController extends Controller
{
    public function index() {
        return view('admin.dashboard');
    }
}
