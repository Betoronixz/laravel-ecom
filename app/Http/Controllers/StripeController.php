<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function checkout()
    {
        return view('checkout');
    }

    public function session(Request $request)
    {
        $user_id = session()->get("user")["id"];
        $data = DB::table('cart')
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->where('cart.user_id', $user_id)
            ->sum("price");
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        $variable = $request->all(); 
    
        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'inr',
                        'product_data' => [
                            'name' => 'gimme money!!!!',
                        ],
                        'unit_amount'  => $data * 100
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'payment',
            'success_url' => route('success', ['variable' => $variable]),
            'cancel_url'  => route('checkout'),
        ]);
    
        // Store paymentIntentId in the session
        session(['paymentIntentId' => $session->payment_intent]);
    
        return redirect()->away($session->url);
    }
    


    public function success(Request $request)
    {
        $requestData = $request->input('variable');
        $user_id = session()->get("user")["id"];
        $allcart = Cart::where("user_id", $user_id)->get();
    
        foreach ($allcart as $cart) {
            $order = new Order;
            $order->product_id = $cart->product_id;
            $order->user_id = $cart->user_id;
            $order->mobile = $requestData['mobile'];
            $order->address = $requestData['shipping_address'];
            $order->status = "completd";
            $order->paymnet_method = "online";
            $order->paymnet_status = "completed";
            $order->save();
        }
    
        Cart::where("user_id", $user_id)->delete();
        return redirect("/");
    }
}