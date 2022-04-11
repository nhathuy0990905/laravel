<?php

namespace App\Http\Requests;

use App\Rules\Uppercase;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_name'  => ['required','min:6',new Uppercase],
            'product_price' => 'required|integer'
        ];
    }

    public function messages(){
        return [
            'product_name.required' => ":attribute bắt buộc phải nhập",
            'product_name.min'      => ":attribute không nhỏ hơn 6 kí tự",
            'product_price.required'=> ":attribute bắt buộc phải nhập",
            'product_price.integer' => ":attribute phải là số"
        ];
    }

    public function attributes(){
        return [
            'product_name' => "Tên sản phẩm",
            'product_price' => "Giá sản phẩm"
        ];
    }

}
