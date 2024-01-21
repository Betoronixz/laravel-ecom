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
    function add_to_cart(Request $req)
    {
        $user = auth()->user();
        if ($user) {
            $user_id = $user->id;
            $cart = new Cart();
            $cart->user_id = $user_id;
            $cart->product_id = $req->product_id;
            $cart->save();
            return redirect("/");
        } else {
            return redirect("/");
        }
    }

    static function cart_count()
    {
        $user = auth()->user();
        if ($user)  {

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
                ->get();

            return view("cartlist", ["data" => $data]);
        } else {
            // Handle the case when user information is not available
            return redirect()->route('login'); // Redirect to the login page or handle it appropriately
        }
    }


    public function ordernow()
    {
        $user = auth()->user();

        if ($user) {
            $user_id = $user->id;
        }
        $data = DB::table('cart')
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->where('cart.user_id', $user_id)
            ->sum("price");
        return view("ordernow", ["data" => $data]);
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
    public function edit_product($id)
    {
        $data = new Product;

        return view("admin.edit_product", ["data" => $data->find($id)]);
    }
    public function update_product(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->category = "LG";
        $product->price = $request->price;
        $product->description = $request->description;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/products/', $filename);
            $product->gallery = $filename;
        }
        $product->save();
        Session::flash('message', 'Producty Inserted Succesfully');

        return redirect("admin/edit_product/$id");
    }
}
