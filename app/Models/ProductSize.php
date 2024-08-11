<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $table = 'product_sizes';

    protected $fillable = [
        'productId',
        'size',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId');
    }
}
