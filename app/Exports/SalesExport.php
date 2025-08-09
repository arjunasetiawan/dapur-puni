<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExport implements FromView
{
    protected $range, $start, $end;

    public function __construct($range, $start, $end)
    {
        $this->range = $range;
        $this->start = $start;
        $this->end = $end;
    }

    public function view(): View
    {
        $orders = Order::with('product')
            ->whereBetween('created_at', [$this->start, $this->end])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.exports.sales', [
            'orders' => $orders,
            'range' => $this->range,
            'start' => $this->start,
            'end' => $this->end,
        ]);
    }
}