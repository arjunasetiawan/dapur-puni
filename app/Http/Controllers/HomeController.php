<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Category;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('usertype', 'user')->count();
        $product = Product::count();
        $order = Order::count();
        $delivered = Order::where('status', 'Delivered')->count();

        $monthlyOrders = [
            'productA' => array_fill(0, 12, 0),
            'productB' => array_fill(0, 12, 0),
            'productC' => array_fill(0, 12, 0),
        ];

        $orders = DB::table('orders')
            ->selectRaw("MONTH(created_at) as month, COUNT(*) as total")
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        foreach ($orders as $month => $total) {
            $monthlyOrders['productA'][$month - 1] = $total;
        }

        $deliveredOrders = DB::table('orders')
            ->selectRaw("MONTH(created_at) as month, COUNT(*) as total")
            ->whereYear('created_at', now()->year)
            ->where('status', 'Delivered')
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        foreach ($deliveredOrders as $month => $total) {
            $monthlyOrders['productB'][$month - 1] = $total;
        }

        $canceledOrders = DB::table('orders')
            ->selectRaw("MONTH(created_at) as month, COUNT(*) as total")
            ->whereYear('created_at', now()->year)
            ->whereRaw('LOWER(payment_status) = ?',[ 'cancel'])
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        foreach ($canceledOrders as $month => $total) {
            $monthlyOrders['productC'][$month - 1] = $total;
        }

        $startMonthIndex = now()->month - 1;
        $data = Order::with('product')->paginate(20);

        return view('admin.index', compact(
            'user', 'product', 'order', 'delivered',
            'monthlyOrders', 'startMonthIndex', 'data'
        ));
    }

    public function home()
    {
        $product = Product::all();
        $count = Auth::check() ? Cart::where('user_id', Auth::id())->count() : '';
        return view('home.index', compact('product', 'count'));
    }

    public function login_home()
    {
        return $this->home();
    }

    public function product_details($id)
{
    $data = Product::find($id);

    if (!$data) {
        abort(404, 'Produk tidak ditemukan');
    }

    $testimonials = Testimonial::where('product_id', $id)->get();

    return view('home.product_details', compact('data', 'testimonials'));
}
    public function add_cart($id)
    {
        $data = new Cart;
        $data->user_id = Auth::id();
        $data->product_id = $id;
        $data->save();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Product added to cart.');
        return redirect()->back();
    }

    public function mycart()
    {
        $count = Cart::where('user_id', Auth::id())->count();
        $cart = Cart::where('user_id', Auth::id())->get();
        return view('home.mycart', compact('count', 'cart'));
    }

    public function delete_cart($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$cart) {
            toastr()->timeOut(10000)->closeButton()->addError('Cart item not found.');
            return redirect()->back();
        }

        $cart->delete();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Product removed from cart.');
        return redirect()->back();
    }

    public function confirm_order(Request $request)
{
    $userId = Auth::id();

    // Ambil semua data cart milik user
    $cartItems = Cart::where('user_id', $userId)->get();

    if ($cartItems->isEmpty()) {
        return redirect()->back()->with('message', 'Keranjang anda kosong.');
    }

    // Simpan setiap item cart sebagai satu baris order
    foreach ($cartItems as $item) {
        Order::create([
            'user_id'        => $userId,
            'product_id'     => $item->product_id,
            'quantity'       => $item->quantity,
            'price'          => $item->product->price,
            'rec_address'    => $request->address,
            'phone'          => $request->phone,
            'name'           => $request->name,
            'status'         => 'in progress',
            'payment_status' => 'Cash on Delivery',
        ]);
    }

    // Kosongkan cart setelah berhasil order
    Cart::where('user_id', $userId)->delete();

    // Redirect ke halaman sukses
    return redirect('/payment/success')->with('message', 'Order Cash On Delivery berhasil dibuat!');
}

    public function myorders(Request $request)
    {
        $type = $request->query('type', 'all');
        $query = Order::with('product')->where('user_id', Auth::id());

        if ($type !== 'all') {
            $query->where('status', $type);
        }

        $order = $query->get();
        return view('home.order', compact('order'));
    }

  public function shop(Request $request)
{
    $categories = Category::all();
    $categoryId = $request->query('category');

    if ($categoryId) {
        // ✅ Perhatikan kolom yang digunakan: category_id
        $product = Product::where('category_id', $categoryId)->get();
    } else {
        $product = Product::all();
    }

    $count = session('cart') ? count(session('cart')) : 0;

    return view('home.shop', compact('product', 'categories', 'count'));
}
    public function cancel_order(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'other_reason' => 'nullable|string|max:255',
        ]);

        $order = Order::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$order) {
            toastr()->timeOut(10000)->closeButton()->addError('Pesanan tidak ditemukan.');
            return redirect()->back();
        }

        if (strtolower($order->status) === 'delivered') {
            toastr()->timeOut(10000)->closeButton()->addWarning('Pesanan yang sudah dikirim tidak bisa dibatalkan.');
            return redirect()->back();
        }

        $order->status = 'canceled';
        $order->payment_status = 'cancel';
        $order->is_seen_by_admin = false;
        $order->cancel_reason = $request->cancel_reason === 'Lainnya' && $request->filled('other_reason')
            ? $request->other_reason
            : $request->cancel_reason;

        $order->save();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Pesanan berhasil dibatalkan.');
        return redirect()->back();
    }

    public function testimonial_view()
    {
        $testimonials = Testimonial::with('user')->latest()->get();
        return view('home.testimonial', compact('testimonials'));
    }

    public function submit_testimonial(Request $request)
    {
        $request->validate([
            'comment' => 'required|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Thank you for your testimonial!');
    }
    public function testimonial()
{
    $testimonials = Testimonial::with('user')->latest()->get();

    return view('home.testimonial', compact('testimonials'));
}
 public function aboutus()
    {
        return view('home.aboutus');
    }
}
