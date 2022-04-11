<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // echo ' Start Dashboard';
    }

    public function index(){
        return '<h1>Dashboard</h1>';
    }
}
