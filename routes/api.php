<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\CostGroupController;
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

//Costs
Route::post('/costs', [CostController::class, 'store'])->middleware(['auth:sanctum']);
Route::delete('/costs/{id}', [CostController::class, 'destroy'])->middleware(['auth:sanctum']);
Route::put('/costs/{id}', [CostController::class, 'update'])->middleware(['auth:sanctum']);
Route::get('/costs', [CostController::class, 'index'])->middleware(['auth:sanctum']);


//CstGroups
Route::get('costgroups/{user_id}',[CostGroupController::class,'index'])->middleware(['auth:sanctum']);

Route::get('/test_token',function(Request $request){

    $user = $request->user();
//    foreach ($user->tokens as $token) {
//        dump($token);
//    }
    if($user->tokenCan('finance')){
        dd('can fin post');
    }
})->middleware(['auth:sanctum']);
