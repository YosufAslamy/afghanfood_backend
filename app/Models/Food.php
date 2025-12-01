<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $table = 'foods';  

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'photo_url',
        'is_vegetarian',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
