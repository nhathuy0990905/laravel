<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct(Request $request){
        if($request->is('categories')){
            echo '<h3>Hello Request</h3>';
        }
    }

    // Hiển thị danh sách chuyên mục ( Phương thức Get )
    public function index(Request $request){

        // if (isset($_GET['id'])) {
        //     echo "Đường link này có id = ".$_GET['id'];
        // }
        
        
        return view('clients.categories.list');
    }

    // Lấy ra 1 chuyên mục theo id ( Phương thức Get)
    public function getCategory($id){
        return view('clients.categories.edit');
    }

    //Sửa 1 chuyên mục ( Phương thức Post )
    public function updateCategory($id){
        return 'Nhấn vào Submit Form để sửa chuyên mục';
    }

    // Show form thêm dữ liệu ( Phương thức Get )
    public function addCategory(){
        return view('clients.categories.add');
    }

    // Thêm dữ liệu vào chuyên mục ( Phương thức Post )
    public function handleAddCategory($id){
        // redirect(route('categories.add'));
        // return 'Submit thêm chuyên mục';

        

    }

    // Xóa dữ liệu ( Phương thức Delete )
    public function delete($id){
        return 'Xóa chuyên mục';
    }

}
