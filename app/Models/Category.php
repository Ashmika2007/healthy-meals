<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes; // enable soft deletes

    protected $fillable = ['name'];

    // Relationship: a category has many meals
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
