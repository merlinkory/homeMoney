<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(){
        $currencies = [
            'VND', 'RUB', 'USD', 'THB'
        ];

        return response(['code' => 1, 'data'=> $currencies],200)->header('Content-Type', 'application/json');
    }
}
