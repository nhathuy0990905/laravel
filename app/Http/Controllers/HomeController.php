<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $title = "Laravel";
        $content = "PHP";
        return view('home2',compact('title','content'));
    }

    public function getProductDetail($id){
        return view('clients.products.detail',compact('id'));
    }
}
