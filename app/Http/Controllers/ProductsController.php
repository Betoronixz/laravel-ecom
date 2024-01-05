<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if(session()->has("user")){

            $user_id = session()->get('user')['id'];
    
            $items = Cart::where('user_id',$user_id)->get();
            return count($items);
        }else{
            return 0;
        }
    }

    public function cartlist(){
        $user_id=session()->get("user")["id"];
        $data= DB::table('cart')
        ->join('products','cart.product_id','=','products.id')
        ->where('cart.user_id',$user_id)
        ->get();
        return view("cartlist",["data"=>$data]);
    
    }
    public function ordernow(){
        $user_id=session()->get("user")["id"];
        $data= DB::table('cart')
        ->join('products','cart.product_id','=','products.id')
        ->where('cart.user_id',$user_id)
        ->sum("price");
        return view("ordernow",["data"=>$data]);
    
    }
    public function placeorder(Request $req){
        $user_id=session()->get("user")["id"];
        $allcart=Cart::where("user_id",$user_id)->get();
        foreach($allcart as $cart){
            $order=new Order;
            $order->product_id=$cart->product_id;
            $order->user_id=$cart->user_id;
            $order->mobile=$req->mobile;
            $order->address=$req->shipping_address;
            $order->status="pending";
            $order->paymnet_method=$req->payment_method   ;
            $order->paymnet_status="pending";
            $order->save();
        }
        Cart::where("user_id",$user_id)->delete();
        return redirect("/");
    }
}
