<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Testimonial extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'user_id',
        'product_id',
        'comment',
        'rating',
    ];

    // Relasi ke user (siapa yang memberi testimonial)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke produk (opsional, jika ada)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
