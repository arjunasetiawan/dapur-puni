<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\Admin;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TestimonialController;

// home
route::get('/',[HomeController::class,'home']);

route::get('/dashboard',[HomeController::class,'login_home'])->middleware(['auth', 'verified'])->name('dashboard');

route::get('/shop',[HomeController::class,'shop'])->middleware(['auth', 'verified'])->name('shop');

route::get('/testimonial',[HomeController::class,'testimonial'])->middleware(['auth', 'verified'])->name('testimonial');

route::get('/aboutus',[HomeController::class,'aboutus'])->middleware(['auth', 'verified'])->name('aboutus');

route::get('/myorders',[HomeController::class,'myorders'])->middleware(['auth', 'verified'])->name('myorders'); 




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route untuk admin
route::get('admin/dashboard',[HomeController::class,'index']) ->
middleware(['auth','admin']);

// Route untuk categori
route::get('view_category',[AdminController::class,'view_category']) ->
middleware(['auth','admin']);

// Route untuk add categori
route::post('add_category',[AdminController::class,'add_category']) ->
middleware(['auth','admin']);

// Route untuk Hapus categori
route::get('delete_category/{id}',[AdminController::class,'delete_category']) ->
middleware(['auth','admin']);

// Route untuk edit categori
route::get('edit_category/{id}',[AdminController::class,'edit_category']) ->
middleware(['auth','admin']);

// Route untuk update categori
route::post('update_category/{id}',[AdminController::class,'update_category']) ->
middleware(['auth','admin']);

// Route untuk add product
route::get('add_product',[AdminController::class,'add_product']) ->
middleware(['auth','admin']);


// Route untuk upload product
route::post('upload_product',[AdminController::class,'upload_product']) ->
middleware(['auth','admin']);


// Route view  product
route::get('view_product',[AdminController::class,'view_product']) ->
middleware(['auth','admin']);

// Route delete product
route::get('delete_product/{id}',[AdminController::class,'delete_product']) ->
middleware(['auth','admin']);

// Route form edit product
route::get('update_product/{id}',[AdminController::class,'update_product']) ->
middleware(['auth','admin']);

// Route nambah product
route::post('edit_product/{id}',[AdminController::class,'edit_product']) ->
middleware(['auth','admin']);


// Route form search product
route::get('product_search',[AdminController::class,'product_search']) ->
middleware(['auth','admin']);

// Route details product
route::get('product_details/{id}',[HomeController::class,'product_details']);

// Route addcart product
route::post('add_cart/{id}',[HomeController::class,'add_cart'])->
middleware(['auth','verified']);

// Route cart product
route::get('mycart',[HomeController::class,'mycart'])->
middleware(['auth','verified']);

// Route remove cart product
route::get('delete_cart/{id}',[HomeController::class,'delete_cart'])->
middleware(['auth','verified']);

// confirm cart product
route::post('confirm_order', [HomeController::class, 'confirm_order'])->
middleware(['auth', 'verified']);

// view order product
route::get('view_orders', [AdminController::class, 'view_orders'])->
middleware(['auth', 'admin']);

route::get('view_cancel', [AdminController::class, 'view_cancel'])->
middleware(['auth', 'admin']);

route::get('order_search',[AdminController::class,'order_search']) ->
middleware(['auth','admin']);

route::get('on_the_way/{id}',[AdminController::class,'on_the_way']) ->
middleware(['auth','admin']);

route::get('delivered/{id}',[AdminController::class,'delivered']) ->
middleware(['auth','admin']);

route::get('print_pdf/{id}',[AdminController::class,'print_pdf']) ->
middleware(['auth','admin']);

// routes/web.php
route::get('print_all_pdf', [AdminController::class, 'print_all_pdf'])->middleware(['auth', 'admin']);

Route::post('/pay', [PaymentController::class, 'processPayment']);
Route::post('/payment/success', [PaymentController::class, 'paymentSuccess']);
Route::get('/payment/success', function () {
    return view('payment.success');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // untuk tampilkan form
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update'); // untuk proses update
});

Route::put('/cancel-order/{id}', [HomeController::class, 'cancel_order'])->name('user.order.cancel');

Route::get('/admin/orders/mark-seen', [AdminController::class, 'markOrdersSeen'])->name('admin.markOrdersSeen');

// Form submit testimonial

Route::post('/submit_testimonial/{id}', [TestimonialController::class, 'submit'])->name('testimonial.submit');

Route::get('/testimonial', [HomeController::class, 'testimonial']);

Route::get('/admin/export-sales', [AdminController::class, 'exportSales'])->name('admin.exportSales');


Route::get('/reset-notifikasi', function () {
    Order::where(function ($query) {
        $query->where('status', 'canceled')
              ->orWhere('payment_status', 'pembayaran berhasil');
    })->update(['is_read' => true]);

    return response()->json(['success' => true]);
})->name('reset.notifikasi');

Route::post('/admin/hitung-keuntungan', [AdminController::class, 'calculateProfit'])->name('admin.calculateProfit');
// User Management Routes
Route::get('/admin/users', [AdminController::class, 'viewUsers'])->name('admin.viewUsers');
Route::get('/admin/users/{id}', [AdminController::class, 'showUser'])->name('admin.showUser');
Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.editUser');
Route::post('/admin/users/{id}/update', [AdminController::class, 'updateUser'])->name('admin.updateUser');
Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
Route::get('/view_user', [AdminController::class, 'viewUsers'])->name('admin.viewUsers');
