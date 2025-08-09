<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function processPayment(Request $request)
    {
        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $request->total,
            ],
            'customer_details' => [
                'first_name' => $request->name,
                'email' => 'user@example.com',
                'phone' => $request->phone,
                'billing_address' => [
                    'address' => $request->address,
                ],
                'shipping_address' => [
                    'address' => $request->address,
                ],
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json(['token' => $snapToken]);
    }

    public function paymentSuccess(Request $request)
    {
        $userId = Auth::id();

        $cartItems = Cart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect('/shop')->with('error', 'Keranjang kamu kosong.');
        }

        foreach ($cartItems as $item) {
            Order::create([
                'user_id' => $userId,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity ?? 1,
                'price' => $item->product->price ?? 0,
                'rec_address' => $request->address,
                'phone' => $request->phone,
                'name' => $request->name,
                'status' => 'in progress',
                'payment_status' => 'Pembayaran berhasil',
            ]);
        }

        Cart::where('user_id', $userId)->delete();

        return view('payment.success');
    }
}
