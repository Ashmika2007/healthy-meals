<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','description','price','category_id','image','is_published'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
