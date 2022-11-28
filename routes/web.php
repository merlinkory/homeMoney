<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\CostGroupController;
use App\Http\Controllers\CurrencyController;

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

Route::get('/clientarea', function () {
    return view('vue');
})->middleware(['auth:sanctum']);

Route::get('/clientarea/cost_list', function () {
    return view('vue');
})->middleware(['auth:sanctum']);

Route::get('/clientarea/create', function () {
    return view('vue');
})->middleware(['auth:sanctum']);

Route::get('/clientarea/report', function () {
    return view('vue');
})->middleware(['auth:sanctum']);


Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

//Costs
Route::get('/costs/{subdays}', [CostController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/costs', [CostController::class, 'store'])->middleware(['auth:sanctum']);
Route::delete('/costs/{id}', [CostController::class, 'destroy'])->middleware(['auth:sanctum']);
Route::put('/costs/{id}', [CostController::class, 'update'])->middleware(['auth:sanctum']);
Route::post('/costs/report',[CostController::class,'report']);

//CstGroups
Route::get('cost-groups/{user_id}',[CostGroupController::class,'index'])->middleware(['auth:sanctum']);

//currency
Route::get('currencies',[CurrencyController::class,'index'])->middleware(['auth:sanctum']);;
