<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;
class DashboardController extends Controller
{
    public function dashboard()
    {
        $product = Product::all();
        return view("admin.dashboard", ['product' => $product]);
    }
    public function add_product()
    {
        return view("admin.add_product");
    }
    public function insert_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $product = new Product();
        $product->name = $request->name;
        $product->category = "LG";
        $product->price = $request->price;
        $product->description = $request->description;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('uploads/products/', $filename);
            $product->gallery	 = $filename;
        }
        $product->save();
        Session::flash('message', 'Producty Inserted Succesfully'); 

        return view("admin/add_product");
    }
}
