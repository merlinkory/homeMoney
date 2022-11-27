<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(){
        $currencies = [
            'VND' =>[
                'precision'=> 0
            ],
            'RUB' => [
                'precision'=> 2
            ],
            'USD' =>[
                'precision'=> 2
            ],
            'THB' =>[
                'precision'=> 2
            ]
        ];

        return response(['code' => 1, 'data'=> $currencies],200)->header('Content-Type', 'application/json');
    }
}
