<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Product hasMany OrderItems
     * Satu produk bisa ada di banyak order items
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Product hasManyThrough Orders
     * Produk ini pernah dipesan di order mana saja
     */
    public function orders()
    {
        return $this->hasManyThrough(
            Order::class,
            OrderItem::class,
            'product_id',  // FK di order_items
            'id',          // FK di orders
            'id',          // PK di products
            'order_id'     // Local key di order_items
        );
    }
}