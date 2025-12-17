<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total_amount',
        'shipping_address',
        'phone',
        'notes',
    ];

    // ==================== RELASI ====================

    /**
     * Order belongsTo User
     * Satu pesanan dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order hasMany OrderItems
     * Satu pesanan memiliki banyak item
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Order hasManyThrough Products
     * Akses langsung ke produk melalui order items
     */
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            OrderItem::class,
            'order_id',   // FK di order_items
            'id',         // FK di products
            'id',         // PK di orders
            'product_id'  // Local key di order_items
        );
    }

    // ==================== HELPER ====================

    public static function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
    }
}