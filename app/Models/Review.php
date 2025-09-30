<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mongodb\Laravel\Eloquent\Model as Eloquent;  // <-- updated

class Review extends Eloquent
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'reviews';

    protected $fillable = [
        'user_id',
        'meal_id',
        'rating',
        'comment',
        'approved',
        'meta'
    ];
}
