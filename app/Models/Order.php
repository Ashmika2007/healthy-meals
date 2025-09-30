<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_price', // optional if you store it
    ];

    // Each order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each order has many items (OrderItem)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Optional: calculate total dynamically from items
    public function getTotalPriceAttribute()
    {
        return $this->items->sum(fn($item) => $item->quantity * $item->price);
    }
}
