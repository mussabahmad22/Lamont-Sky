<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Models\AllCategory;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Products;

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

Route::get('/', function () {
    $categories = AllCategory::all()->count();
    $subcat = SubCategory::all()->count();
    $products = Products::all()->count();
    return view('admin.dashboard',compact('categories','subcat','products'));
})->middleware(['auth']);

Route::middleware('auth')->group(function () {

    Route::get('/admin_logout', [AdminController::class, 'logout'])->name('admin_logout');

    // Route::get('menus', [AdminController::class, 'index'])->name('category');
    // Route::get('menus-show',[AdminController::class, 'show']);
    // Route::post('menus',[AdminController::class, 'store'])->name('menus.store');

    //===============================Categoury Routes=============================================
    Route::get('category', [AdminController::class, 'category'])->name('category');
    Route::post('category', [AdminController::class, 'add_category'])->name('addCategory');
    Route::get('categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('edit_category/{id}', [AdminController::class, 'edit_category'])->name('edit_category');
    Route::PUT('category_update', [AdminController::class, 'category_update'])->name('category_update');
    Route::delete('category_delete', [AdminController::class, 'category_delete'])->name('category_delete');

    //===============================Sub Categoury Routes=============================================
    Route::get('subcategory/{id}', [AdminController::class, 'subcategory'])->name('subcategory');
    Route::get('subcategoryshow/{id}', [AdminController::class, 'show_sub_category'])->name('showsubCategory');
    Route::post('add_sub_category', [AdminController::class, 'add_sub_category'])->name('addSubCategory');
    Route::get('subcategoryshow/edit_sub_category/{id}', [AdminController::class, 'edit_sub_category'])->name('edit_sub_category');
    Route::PUT('sub_category_update', [AdminController::class, 'sub_category_update'])->name('sub_category_update');
    Route::delete('sub_category_delete', [AdminController::class, 'sub_category_delete'])->name('sub_category_delete');

    //===============================Products Routes=============================================
    Route::get('products/{id}', [AdminController::class, 'products'])->name('products');
    Route::get('show_products/{id}', [AdminController::class, 'show_products'])->name('show_products');
    Route::post('add_products', [AdminController::class, 'add_products'])->name('add_products');
    Route::get('show_products/edit_products/{id}', [AdminController::class, 'edit_products'])->name('edit_products');
    Route::PUT('product_update', [AdminController::class, 'product_update'])->name('product_update');
    Route::delete('product_delete', [AdminController::class, 'product_delete'])->name('product_delete');


});

Route::get('/dashboard', function () {
    $categories = AllCategory::all()->count();
    $subcat = SubCategory::all()->count();
    $products = Products::all()->count();
    return view('admin.dashboard',compact('categories','subcat','products'));
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
