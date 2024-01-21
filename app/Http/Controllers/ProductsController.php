<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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


    public function add_to_cart(Request $req)
    {
        $user = auth()->user();

        if ($user) {
            $user_id = $user->id;
            $product_id = $req->product_id;
            $existingCartItem = Cart::where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->first();

            if ($existingCartItem) {
                $existingCartItem->qty += 1; // You can adjust this logic based on your requirements
                $existingCartItem->save();
            } else {
                $cart = new Cart();
                $cart->user_id = $user_id;
                $cart->product_id = $product_id;
                $cart->qty = 1; // You can set the initial quantity based on your requirements
                $cart->save();
            }
            return redirect("/");
        } else {
            return redirect("/");
        }
    }


    static function cart_count()
    {
        $user = auth()->user();
        if ($user) {

            $user_id = $user->id;
            $items = Cart::where('user_id', $user_id)->get();
            return count($items);
        } else {
            return 0;
        }
    }

    public function cartlist()
    {
        $user = auth()->user();

        if ($user) {
            $user_id = $user->id;

            $data = DB::table('cart')
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->where('cart.user_id', $user_id)
                ->select(
                    'cart.id as cart_id', // Alias the cart.id as cart_id
                    'cart.qty', // Include other columns from the cart table
                    'products.id as product_id', // Alias the products.id as product_id
                    'products.*' // Include other columns from the products table
                )
                ->get();

            return view("cartlist", ["data" => $data]);
        } else {
            return redirect()->route('login'); // Redirect to the login page or handle it appropriately
        }
    }
    public function edit_cart(Request $req)
    {
        $cart = Cart::find($req->id);
        $user = auth()->user();
    
        if ($user && $cart && $cart->user_id == $user->id) {
            $cart->qty = $req->qty;
            $cart->save();
            return redirect("/cartlist");
        } else {
            return redirect("/login");
        }
    }
    
    public function delete_cart($id)
    {
        $user = auth()->user();
        $cart = Cart::find($id);
    
        if ($user && $cart && $cart->user_id == $user->id) {
            $cart->delete();
            return redirect("/cartlist");
        } else {
            return redirect("/login");
        }
    }
    

    public function ordernow()
    {
        $user = auth()->user();

        if ($user) {
            $user_id = $user->id;
        }else{
            return redirect("/login");
        }
        $data = DB::table('cart')
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->where('cart.user_id', $user_id)
            ->select(
                'products.id',
                'products.name',
                'products.price',
                'cart.qty'
            )
            ->get();
        $totalPrice = 0;

        foreach ($data as $item) {
            $totalPrice += $item->qty * $item->price;
        }
        return view("ordernow", ["data" => $totalPrice]);
    }
    public function placeorder(Request $req)
    {
        $user = auth()->user();

        if ($user) {
            $user_id = $user->id;
        }
        $allcart = Cart::where("user_id", $user_id)->get();
        foreach ($allcart as $cart) {
            $order = new Order;
            $order->product_id = $cart->product_id;
            $order->user_id = $cart->user_id;
            $order->mobile = $req->mobile;
            $order->address = $req->shipping_address;
            $order->status = "pending";
            $order->paymnet_method = $req->payment_method;
            $order->paymnet_status = "pending";
            $order->save();
        }
        Cart::where("user_id", $user_id)->delete();
        return redirect("/");
    }
    
}
