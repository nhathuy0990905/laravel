<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Blade\HomeBladeController;
use App\Http\Controllers\HomeController13;
use App\Http\Controllers\HomeController2;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\UsersController;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// ------------------Route----------------------------
// - Nếu 2 route trùng đường dẫn thì laravel sẽ lấy route theo thứ tự từ dưới lên trên

Route::get('home', function () {
    return view('home');
});
Route::post('unicode', function () {
    return 'Post';
});
Route::get('tin-tuc/{$id}', function ($id) {            // id bắt buộc
    return 'Tin tức số : '.$id;    
});
Route::get('products/{id?}', function ($id=null) {      // id không bắt buộc
    return 'Sản phẩm có mã id : '.$id;
});

Route::get('tin-tuc/{day?}/{content?}', function ($day,$content) {
    return 'Tin tức số : '.$day.' có nội dung : '.$content;    
});


Route::prefix('admin')->group(function () {             // Nhóm route
    Route::get('home', function () {
        return view('home');
    });
    
    Route::get('show-form', function () {
        return view('form');
    });

    Route::prefix('products2')->group(function () {
        Route::get('/', function () {
            return 'Sản phẩm tại Nhat Huy Store';
        })->name('admin.products.list');
        Route::get('add', function () {
            return 'Thêm sản phẩm';
        })->name('admin.products.add');;
        Route::get('edit', function () {
            return 'Sửa sản phẩm';
        });
        Route::get('delete', function () {
            return 'Xóa sản phẩm';
        });
    });

    Route::get('tin-tuc/{id}-{content}.html', function ($id=null,$content=null) {
        return  " Tin tức số : ".$id."<br/>".
                " Có nội dung : ".$content;
    })->where(
        [
            'id' => '[0-9]+',
            'content' => '[a-z-]+'
        ]
    )->name('admin.tintuc');

});

// ---------------------Controller--------------------------
// Khai báo tên Controller trước khi làm việc

Route::get('gioi-thieu', [HomeController::class, 'intro']);
Route::get('chuyen-muc-san-pham/{id}', [HomeController::class, 'index']);

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoriesController::class, 'index'])->name('categories.list');
    Route::get('edit/{id}', [CategoriesController::class,'getCategory'])->name('categories.edit');
    Route::get('update/{id}', [CategoriesController::class,'updateCategory']);
    Route::get('add', [CategoriesController::class,'addCategory'])->name('categories.add');
    Route::get('handle/{id}', [CategoriesController::class,'handleAddCategory']);
    Route::get('delete/{id}', [CategoriesController::class,'delete'])->name('categories.delete');
});

// --------------------- Middleware-------------------------
// - Middleware : Lọc dữ liệu trước khi Request đi vào Controller
// - Tạo middleware
// - Khai báo middleware ở Kernel.php

Route::get('/', function () {
    return '<h1>NHAT HUY STORE</h1>';
})->name('home');

Route::middleware('auth.admin')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('products', ProductsController::class);
});

// --------------------- View -------------------------
// Có 2 cách đổ dữ liệu ra view : 
// - Đổ dữ liệu từ route
// - Đổ dữ liệu từ controller

/* Cách 1 :

Route::get('/', function () {
    $title = "Laravel";
    $content = "PHP";
    $data = [
        'title' => $title,
        'content' => $content
    ];
    return view('home2',$data);
})->name('home2');

*/

// Cách 2 : HomeController.php
// Khai báo tên Controller ở đầu file 

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('san-pham/{id}', [HomeController::class,'getProductDetail'])->name('getproductdetail');

// --------------------- HTTP Request --------------------

// // ----------------------------------- 1. $request->path() -----------------------------------

// // - path() trả về thông tin đường dẫn của request.

// // ví dụ URL http://localhost:8001/category
//     $uri = $request->path();
// // kết quả trả về  "category"

// // ----------------------------------- 2. $request->is() -----------------------------------

// // - is() cho phép kiểm tra xem đường dẫn request có khớp với một mẫu hay không, sử dụng ký tự * để trùng khớp tất cả.

// if ($request->is('category/*')) {
//     // các đường dẫn bắt đầu bằng category/ được xử lý
//     // ví dụ http://localhost:8001/category/create, http://localhost:8001/category/update
// }
// if ($request->is('category/create')) {
//     echo "Đường dẫn bạn vừa truy nhập đúng là http://localhost:8001/category/create {$request->path()}";
// }

// // ----------------------------------- 3. $request->url() -----------------------------------

// // - url() trả về đường dẫn của URL không chứa query string.

// // Ta có đường dẫn : http://localhost:8001/category?param=laravel (?param=laravel : query string)
// $url = $request->url();
// // trả về http://laravel.dev/category

// // ----------------------------------- 4. $request->fullUrl() -----------------------------------

// // - fullUrl() trả về đẩy đủ URL kể cả query string

// // Ta có đường dẫn : http://localhost:8001/category?param=laravel (?param=laravel : query string)
// $url = $request->fullUrl();
// // trả về http://laravel.dev/category?param=laravel

// // ----------------------------------- 5. $request->method() -----------------------------------

// // - method() trả về hành động của request là GET hay POST ...

// // Ngoài ra bạn cũng có thể sử dụng isMethod để xác định hành động có phải là GET, POST ... hay không?


//  $method = $request->method();
//  if ($request->isMethod('get')) {
//     echo 'GET request';
//  } else {
//     echo 'POST request';
//  }

// // ----------------------------------- 6. $request->route()->getName() -----------------------------------

// // - getName() trả về name của route


// Route::get('category', 'CategoryController@index')->name('category.index');

// $nameRoute = $request->route()->getName();
// // // kết quả là: 'category.index'

// //  ----------------------------------- 7. $request->ip()  -----------------------------------

// // Phương thức này trả về địa chỉ ip của người dùng.

// // Ví dụ:

// $ipAddress = $request->ip();
// echo "Địa chỉ IP người dùng: {$ipAddress}";

// //  ----------------------------------- 8 $request->server()  -----------------------------------

// // Phương thức này trả về các thông tin liên quan đến máy chủ.
// // Một số thông tin hay được sử dụng:
// //      REQUEST_TIME: thời gian yêu cầu gửi đến máy chủ web
// //      QUERY_STRING: query string trong URL
// //      URL_REFERER: đường dẫn url tham chiếu
// //      SERVER_ADDR: Địa chỉ máy chủ
// //      REQUEST_SCHEME: giao thức sử dụng

// $serverAddress = $request->server('SERVER_ADDR');
// echo "Địa chỉ IP máy chủ: . {$serverAddress}";


// // ----------------------------------- 9. $request->header() -----------------------------------

// // Phương thức này trả về các thông tin header của request như: thông tin về trình duyệt sử dụng user-agent, thông tin về dữ liệu cookie, trong tin về host yêu cầu ...

// // Ví dụ:

// // // file định nghĩa route: web.php
// Route::get('category', 'CategoryController@getInfo');

// // // CategoryController.php

// // public function getInfo(Request $request){
// //     $ipAddress = $request->ip();
// //     echo "Địa chỉ IP người dùng: {$ipAddress}";

// //     $serverAddress = $request->server('SERVER_ADDR');
// //     echo "Địa chỉ IP máy chủ: {$serverAddress}";

// //     $urlReferer = $request->server('URL_REFERER');
// //     echo "Đường dẫn xuất phát: ' . {$urlReferer}";

// //     $userAgent = $request->header('User-Agent');
// //     echo "Thông tin về trình duyệt: {$userAgent}";
// // }

// // ----------------------------------- 10. $request->route('category') -----------------------------------

// // Phương thức này sẽ trả ra instance của Category. Khi đường dẫn bạn gửi lên http://localhost:8001/category/1 thì ở trong controller ta sử dụng $request->route('category') thì nó trả ra cho ta category có id = 1 nếu trong database có.

// // Ví dụ:

// // // file định nghĩa route: web.php
// Route::get('category/{category}', 'CategoryController@update')->name('category.update');


// // //
// //  public function update(Category $category, Request $request)
// //     {
// //        $category = $request->route('category');
       
// //        // $category này chính là category có id = 1 trong database
// //     }

// // ----------------------------------- 11. REQUEST FORM -----------------------------------

// // ----------------------------------- 11.1
// // ----------------------------------- 1) Nhận giá trị input

// // Lấy giá trị trong ô input :
// $name = $request->input('email');

// // Ta có thể truyền vào giá trị mặc định ở đối số thứ hai trong hàm input. Nếu giá trị trong input không có trong request thì giá trị này sẽ được lấy:
// $name = $request->input('email', 'email@gmail.com');

// // Đối với dữ liệu trên form là một mảng dữ liệu ta có thể sử dụng '.' để truy cập vào mảng
// $name = $request->input('categories.0.name');

// $names = $request->input('categories.*.name');

// // ----------------------------------- 2) Nhận giá trị input từ JSON

// // Khi yêu cầu gửi lên dưới đạng JSON, ta có thể truy xuất dữ liệu trong JSON thông qua hàm input với điều kiện header của request Content-Type phải là application/json. Ta có thể sử dụng cú pháp "." để truy xuất sâu hơn vào trong mảng JSON:
// $name = $request->input('categories.name');

// // ----------------------------------- 3) Kiểm tra sự tồn tại giá trị của input

// // Để kiểm tra một giá trị input có tồn tại trên request hay không, ta có thể sử dụng hàm has. Hàm has trả về true nếu như giá trị tồn tại và không phải là chuỗi rỗng:
// if ($request->has('email')) {
//     //
// }

// // ----------------------------------- 4) Nhận tất cả dữ liệu của form

// // Để nhận tất cả dữ liệu từ form ta dử dụng method all():

// $input = $request->all();

// // ----------------------------------- 5) Nhận một phần của dữ liệu input

// // Khi muốn nhận một phần nhỏ dữ liệu trong form ta có thể sử dụng hàm only hoặc except, Cả hai hàm đều nhận một array hoặc một danh sách các đối số:

// $input = $request->only(['email', 'password']);

// $input = $request->only('email', 'password');

// $input = $request->except(['username']);

// $input = $request->except('username');

// // ----------------------------------- 6) Thuộc tính động

// // Ta có thể truy xuất vào input sử dụng thuộc tính động trên đối tượng Illuminate\Http\Request. Ví dụ, nếu một trong các form có chứa trường là email, ta có thể lấy giá trị được post lên như sau:
// $email = $request->email;

// // ----------------------------------- 11.2 Input cũ trong form -----------------------------------

// // Laravel cho phép ta giữ giá trị input từ một request sang request tiếp theo. Đặc điểm này đặc biệt hữu dụng khi bạn muốn thiết lập lại form sau khi phát hiện có lỗi.
// // ----------------------------------- 7) Flash input tới session

// // Hàm flash trong Illuminate\Http\Request sẽ flash input hiện tại vào trong session nên nó có thể sử dụng trong request tiếp theo của user tới ứng dụng:
// $request->flash();

// // ----------------------------------- 8) Flash input vào trong session rồi chuyển trang

// // Nếu muốn flash input cùng với chuyển trang vào trang trước đó, bạn có thể dễ dàng tạo móc nối input vào trong một redirect sử dụng hàm withInput:
// return redirect('form')->withInput();

// return redirect('form')->withInput($request->except('password'));

// // ----------------------------------- 9) Lấy dữ liệu cũ

// // Để lấy dữ liệu đã flash từ request trước đó, ta có thể sử dụng hàm old() cảu request.
// $username = $request->old('username');

// --------------------- BLADE --------------------

Route::get('/blade', [HomeController2::class,'index']);

Route::get('/homebai13', [HomeController13::class,'index'])->name('trangchu');
Route::get('/productbai13', [HomeController13::class,'product'])->name('sanpham');
Route::get('/them-san-pham', [HomeController13::class,'getAdd']);                           
Route::post('/them-san-pham', [HomeController13::class,'postAdd']);                         // <<<----------------------- VALIDATION -------------------------

// ------------------- COMPONENTS -----------------

//            Sang folder COMPONENTS để học

// ------------------- RESPONSE ------------------

Route::get('thong-tin-api', [ResponseController::class,'api']);
Route::get('response', function () {
    // $response = new Response('',404);
    // return $response;
});

Route::get('form-response', function () {
    return view('client.form-response');
})->name('form-response');

Route::post('form-response', function (Request $request) {
    if(!empty($request->username)){
        return redirect()->route('form-response');
    }
});

// ------------------- VALIDATION ------------------
// Dùng để kiểm tra tính hợp lệ dữ liệu của người dùng nhập vào
// Validate được thực hiện ở hàm Controller
// Sau khi dữ liệu hợp lệ, Controller điều hướng sang trang tiếp theo

// Validation cách 1 : HomeController13.php
//      Validate trực tiếp thông qua Controller ( cách này ta không dùng )

// Validation cách 2 : Sử dụng Request
//      Tạo request :   php artisan make:request [Tên Request]
//          - rules() : Hàm quy tắc ràng buộc
//          - message() : Hàm thông báo
//          - attribute() : Hàm giá trị ( là trường name trong thẻ input )

// Một số thuộc tính hàm validate : 
//      https://hocwebchuan.com/tutorial/laravel/laravel_validate_values.php

// * Luồng xử lý : 
//      
//      web.php ( method : GET ) 
//  -> controller 
//  -> views 
//  -> web.php ( method : POST ) 
//  -> Request 
//  -> Rules + validation.php ( Định nghĩa validate )


// ------------------- DATABASE ------------------

// *** RAW QUERY 

// Có 5 phương thức chính trong Database : 
//  - Select
//  - Insert
//  - Update
//  - Delete
//  - Statement ( đây là phương thức chung của cả 4 phương thức trên )

// Khi sử dụng Statement : ta không chỉ định câu lệnh sql cụ thể mà chỉ dùng chung 1 biến $sql trong file Models\Users.php
//      return DB::statement($sql);
// Sau đó tại file UsersController ta tiến hành chỉ định câu lệnh :
//      $statement = $this->users->statementUser('DELETE FROM user');
//      $statement = $this->users->statementUser('SELECT * FROM user');
//      ...


// - Sử dụng thư viện Database của Laravel :
//      use Illuminate\Support\Facades\DB;

// - Thực hiện câu lệnh SQL tại folder Models :
//      Users.php
// - Tại UsersController : gọi Models ra 
//      $user = new Users();
//   Sau đó sử dụng 1 biến $userList để trỏ đến phương thức trong class Users()
//        $userList = $user->getAllUsers();
// - Truyển dữ liệu từ UsersController.php -> list.blade.php :
//      return view('client.users.lists',compact('userList'));   


Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UsersController::class,'index'])->name('index');
    Route::get('add', [UsersController::class,'add'])->name('add');
    Route::post('add', [UsersController::class,'postAdd'])->name('post-add');
    Route::get('edit/{id}', [UsersController::class,'getEdit'])->name('edit');
    Route::post('update', [UsersController::class,'postEdit'])->name('post-edit');
    Route::get('delete/{id}', [UsersController::class,'delete'])->name('delete');
});


// *** QUERY BUILDER : Học tại file Models\Users.php

// - Sử dụng thư viện Database của Laravel :
//      use Illuminate\Support\Facades\DB;

