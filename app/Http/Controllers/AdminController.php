<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

use App\Models\Order;

use Flasher\Toastr\Prime\ToastrInterface;

use App\Models\Product;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Notification;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;


class AdminController extends Controller
{
    public function view_category()
    {
        $data = Category::all();
        return view('admin.category',compact('data'));
    }

    public function add_category(Request $request)
    {
    $request->validate([
        'category' => 'required|string|max:255',
    ], [
        'category.required' => 'Kolom kategori wajib diisi!',
    ]);

    $category = new Category;
    $category->category_name = $request->category;
    $category->save();

    toastr()->timeOut(10000)->closeButton()->addSuccess('Kategori berhasil ditambahkan!');
    
    return redirect()->back();
}

    public function delete_category($id)
    {
        $data = Category::find($id);

        $data->delete();

         toastr()->timeOut(10000)->closeButton()->addSuccess('Kategori berhasil dihapuss');
        

        return redirect()->back();
    }

    public function edit_category($id)
    {
        $data = Category::find($id);
        return view('admin.edit_category', compact('data'));
    }

    public function update_category(Request $request,$id)
    {
        $data = Category::find($id);

        $data->category_name= $request->category;

        $data->save();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Kategori berhasil diperbarui');

        return redirect('/view_category');
    }

    public function add_product()
    {

        $category = Category::all();

        return view('admin.add_product',compact('category'));
    }


    public function upload_product( Request $request)
    {
        $data = new Product;

        $data->title = $request->title;

        $data->description = $request->description;

        $data->price = $request->price;

        $data->quantity = $request->qty;

        $data->category_id = $request->category_id;


        $image = $request->image;

        if($image)
        {
            $imagename = time().'.'.$image->getClientOriginalExtension();

            $request->image->move('products',$imagename);   

            $data->image = $imagename;
        }
        

        $data->save();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Product Added Successfully');

        return redirect()->back();


    }


    public function view_product()
    {
        $product = Product::paginate(3);
        return view('admin.view_product',compact('product'));
    }

    public function delete_product($id)
    {
        $data = Product::find($id);

        $image_path = public_path('products/' .$data->image);

        if(file_exists($image_path))
        {
            unlink($image_path);
        }

        $data->delete();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Delete Product Successfully');

        return redirect()->back();
    }

    public function update_product($id)
    {
        $data = Product::find($id);

        $category = Category::all();

        return view('admin.update_page',compact('data','category'));
    }

    public function edit_product(Request $request,$id)
    {
        $data = Product::find($id);

        $data->title = $request->title;

        $data->description = $request->description;

        $data->price = $request->price;

        $data->quantity = $request->quantity;

        $data->category = $request->category;

        $image = $request->image;

        if($image)
        {

            $imagename = time().'.'.$image->getClientOriginalExtension();

            $request->image->move('products',$imagename);

            $data->image =  $imagename;
        }

            $data->save();

             toastr()->timeOut(10000)->closeButton()->addSuccess('Product Updated Successfully');

             return redirect('/view_product');

    }

        public function product_search(Request $request)
        {
            $search = $request->search;

            $product = Product::where('title','LIKE','%'.$search.'%')->orWhere('category','LIKE','%'.$search.'%')->paginate(3);

            return view('admin.view_product',compact('product'));
        }
           
            public function view_orders()
             {
                        $data = Order::with('product')->latest()->paginate(3);

                        $notifOrders = Order::where('status', 'canceled')
                                            ->where('is_seen_by_admin', false)
                                            ->get();

                        return view('admin.order', compact('data', 'notifOrders'));
             }

                public function markOrdersSeen()
                {
                    Order::where('status', 'canceled')
                        ->where('is_seen_by_admin', false)
                        ->update(['is_seen_by_admin' => true]);

                    return redirect()->back()->with('success', 'Notifikasi pesanan dibatalkan telah ditandai dibaca.');
                }



        public function order_search(Request $request)
        {
                $search = $request->search;

                // Cari relasi product yang sesuai title atau category
                $data = Order::whereHas('product', function($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('category', 'LIKE', '%' . $search . '%');
                    })->paginate(3);

                return view('admin.order', compact('data'));
        }

        public function on_the_way($id)
        {
            $data = Order::find($id);

            $data->status = 'On the way';

            $data->save();

            return redirect('/view_orders');
        }

        public function delivered($id)
        {
            $data = Order::find($id);

            $data->status = 'Delivered';

            $data->save();

            return redirect('/view_orders');
        }

       public function print_pdf($id)
            {
                $data = Order::find($id);
                $pdf = Pdf::loadView('admin.invoice', compact('data'));
                return $pdf->download('resi_pengiriman.pdf');
            }

        public function print_all_pdf()
        {
                $orders = Order::with('product')->get(); // load relasi product agar tidak error
                $pdf = Pdf::loadView('admin.all_invoice', compact('orders'));
                return $pdf->download('all_orders.pdf');
            }

            public function view_cancel()
             {
                        $data = Order::with('product')->latest()->paginate();

                        $notifOrders = Order::where('status', 'canceled')
                                            ->where('is_seen_by_admin', false)
                                            ->get();

                        return view('admin.cancel', compact('data', 'notifOrders'));
             }
                                public function calculateProfit(Request $request)
                    {
                        $income = $request->input('total_income');
                        $expense = $request->input('total_expense');

                        $profit = $income - $expense;

                        return back()->with('profit', $profit);
                    }
                    public function viewUsers()
{
    $users = User::where('usertype', 'user')->get(); // hanya ambil user biasa
    return view('admin.users', compact('users')); // arahkan ke view yang kamu buat
}

public function exportSales(Request $request)
{
    $request->validate([
        'range' => 'required|in:harian,mingguan,bulanan',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
    ]);

    $range = $request->range;
    $start = $request->tanggal_mulai;
    $end = $request->tanggal_selesai;

    return Excel::download(new SalesExport($range, $start, $end), 'laporan_penjualan.xlsx');
}
public function resetNotifikasi()
{
    Order::where('status', 'canceled')
         ->orWhere('payment_status', 'pembayaran berhasil')
         ->update(['is_read' => true]);

    return redirect()->back();
}

}


