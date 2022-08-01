<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
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

Route::post('/login',  [ApiController::class, 'login']);

//================== Add Users Api ====================================
Route::post('/add_users' , [ApiController::class, 'add_users']);

//================== Update Profile User Api ====================================
Route::post('/edit_user' , [ApiController::class, 'edit_user']);

//===============================Categoury Routes=============================================
Route::get('category', [ApiController::class, 'category'])->name('category'); 

//===============================Subcategoury Routes=============================================
Route::get('Subcategory', [ApiController::class, 'Subcategory'])->name('Subcategory');

//===============================products Routes=============================================
Route::get('products', [ApiController::class, 'products'])->name('products');

//===============================Add order_list against user Routes=============================================
Route::post('add_order_list', [ApiController::class, 'add_order_list'])->name('add_order_list');

//===============================order_list against user Routes=============================================
Route::get('order_list', [ApiController::class, 'order_list'])->name('order_list');

//===============================Banner Img ===========================================
Route::get('banner_img', [ApiController::class, 'banner_img'])->name('banner_img');
