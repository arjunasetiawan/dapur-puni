<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            $count = 0;
            $totalValue = 0;
            $cartItems = collect();

            $notifCanceled = 0;
            $notifAccepted = 0;

            if (Auth::check()) {
                $userId = Auth::id();

                // Cart info
                $count = Cart::where('user_id', $userId)->count();
                $cartItems = Cart::with('product')->where('user_id', $userId)->get();

                foreach ($cartItems as $item) {
                    if ($item->product) {
                        $totalValue += $item->product->price * $item->quantity;
                    }
                }

                // Notifikasi belum dibaca (is_read = false)
                $notifCanceled = Order::where('status', 'canceled')->where('is_read', false)->count();
                $notifAccepted = Order::where('payment_status', 'pembayaran berhasil')->where('is_read', false)->count();
}

            $view->with(compact('count', 'totalValue', 'cartItems', 'notifCanceled', 'notifAccepted'));
        });
    }
}
