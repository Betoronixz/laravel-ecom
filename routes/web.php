<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
Route::get("/details/{id}",[ProductsController::class,"details"]);
Route::view("/login","login")->name("login");
Route::post("/login",[UserController::class,"login"]);
Route::post("/add_to_cart",[ProductsController::class,"add_to_cart"]);