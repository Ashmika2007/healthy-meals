<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'meal_id',
        'quantity',
        'price',
    ];

    // Each item belongs to a meal
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    // Each item belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
