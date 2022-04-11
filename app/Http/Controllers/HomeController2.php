<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController2 extends Controller
{
    public $data = [];
    public function index(){
        $this->data['welcome'] = "Blade PHP";
        $this->data['content'] = "Blade PHP là một cách viết ngắn gọn truyền dữ liệu từ controller sang view ";
        $this->data['check'] = 10;
        return view('home2',$this->data);
    }
}
