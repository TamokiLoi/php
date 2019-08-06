<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'code',
        'content',
        'regular_price',
        'sale_price',
        'original_price',
        'quantity',
        'attributes',
        'image',
        'user_id',
        'category_id'
    ];
}
