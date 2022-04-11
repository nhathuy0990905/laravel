<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function api(){
        $api = [
            'name' => 'Huy',
            'age'  => 18,
            'learn' => 'Laravel'
        ];

        return response()->json($api,201);
    }
}
