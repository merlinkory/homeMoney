<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[UserController::class,'store']);

Route::post('/tokens/create', [UserController::class, 'createToken']);

Route::get('/test_token',function(Request $request){

    $user = $request->user();
//    foreach ($user->tokens as $token) {
//        dump($token);
//    }
    if($user->tokenCan('finance')){
        dd('can fin post');
    }
})->middleware(['auth:sanctum']);
