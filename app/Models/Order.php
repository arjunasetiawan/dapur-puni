<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
        'rec_address',
        'phone',
        'name',
        'status',
        'payment_status',
    ];

    public function user()
    {
        return $this->Hasone('App\Models\User','id','user_id');
    }

    public function product()
    {
        return $this->Hasone('App\Models\Product','id','product_id');
    }
}
