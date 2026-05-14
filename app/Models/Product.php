<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image_url',
        'is_active',
    ];

    public function category()
    {

        return $this->belongsTo(Category::class);
    }
}
