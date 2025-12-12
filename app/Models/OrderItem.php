<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    // ==================== RELASI ====================

    /**
     * OrderItem belongsTo Order
     * Satu item milik satu pesanan
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * OrderItem belongsTo Product
     * Satu item merujuk ke satu produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
