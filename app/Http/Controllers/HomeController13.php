<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;

class HomeController13 extends Controller
{
    public $data = [];
    public function index(){
        $this->data['title'] = "Title";
        
        // $user = DB::select('SELECT * FROM user WHERE id = ?',[1]);
        // dd($user);

        return view('client.home',$this->data);
    }
    public function product(){
        $this->data['product'] = "Trang sản phẩm";
        $this->data['title'] = "Sản phẩm";
        return view('client.product',$this->data);
    }

    public function getAdd(){
        $this->data['title'] = "Sản phẩm";
        return view('client.add',$this->data);
    }

    public function postAdd(ProductRequest $request){

    // Validate trực tiếp :

        // $rules = [
        //     'product_name'  => 'required|min:6',
        //     'product_price' => 'required|integer'
        // ];

        // $messages = [
        //     'product_name.required' => "Tên sản phẩm bắt buộc phải nhập",
        //     'product_name.min'      => "Tên sản phẩm không nhỏ hơn 6 kí tự",
        //     'product_price.required'=> "Giá sản phẩm bắt buộc phải nhập",
        //     'product_price.integer' => "Giá sản phẩm phải là số"
        // ];

        // $request->validate($rules,$messages);

    

        return 'Thêm dữ liệu thành công';
    }

}
