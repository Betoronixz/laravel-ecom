<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminLoginController; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get("/",[ProductsController::class,"index"])->name("home");
Route::get("/search",[ProductsController::class,"search"])->name("search");
Route::get("/ordernow",[ProductsController::class,"ordernow"])->name("search");
Route::get("/cartlist",[ProductsController::class,"cartlist"])->name("cartlist");
Route::post("/edit-cart",[ProductsController::class,"edit_cart"])->name("edit_cart");
Route::get("/delete_cart/{id}",[ProductsController::class,"delete_cart"])->name("delete_cart/");
Route::get("/details/{id}",[ProductsController::class,"details"]);
Route::post("/placeorder",[ProductsController::class,"placeorder"])->name("placeorder");
Route::post("/add_to_cart",[ProductsController::class,"add_to_cart"]);
Route::get("/checkout",[StripeController::class,"checkout"])->name("checkout");
Route::post("/session",[StripeController::class,"session"])->name("session");
Route::get("/success",[StripeController::class,"success"])->name("success");

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'admin'], function() {
    Route::group(['middleware' => 'admin.guest'], function(){
        Route::view('/login','admin.login')->name('admin.login');
        Route::view('/','admin.login');
        Route::post('/login',[AdminLoginController::class, 'authenticate'])->name('admin.auth');
    });
    
    Route::group(['middleware' => ['web', 'admin.auth']], function () {
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/orders', [App\Http\Controllers\DashboardController::class, 'orders'])->name('admin.orders');
        Route::get('/add_product', [App\Http\Controllers\DashboardController::class, 'add_product'])->name('admin.add_product');
        Route::post('/add_product', [App\Http\Controllers\DashboardController::class, 'insert_product'])->name('admin.insert_product');
        Route::get('/edit_product/{id}', [App\Http\Controllers\DashboardController::class, 'edit_product'])->name('admin.edit_product');
        Route::post('/update_product/{id}', [App\Http\Controllers\DashboardController::class, 'update_product'])->name('admin.update_product');
        Route::get('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
    
});