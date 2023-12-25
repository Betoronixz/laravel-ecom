<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $data = Product::all();
        return view("welcome", ["products" => $data]);
    }
    public function details($id)
    {
        $data = Product::find($id);
        return view("details", ["product" => $data]);
    }
    function search(Request $req)
    {
        $data = Product::where("name", "LIKE", "%" . $req->search . "%")->take(1)->get();
        return view("search", ["product" => $data[0]]);
    }
    function add_to_cart(Request $req)
    {
        if ($req->session()->has("user")) {
            $cart = new Cart();
            $cart->user_id = $req->session()->get("user")["id"];
            $cart->product_id = $req->product_id;
            $cart->save();
            return redirect("/");
        } else {
            return redirect("/");
        }
    }

    static function cart_count(){
        $user_id = session()->get('user')['id'];

        $items = Cart::where('user_id',$user_id)->get();
        return count($items);
    }
}
