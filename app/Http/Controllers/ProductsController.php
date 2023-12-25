<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        $data= Product::all();
        return view("welcome",["products"=>$data]);
    }
}
