<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'productId';
    protected $fillable = [
        'productName',
        'description',
        'mainCategory',
        'subCategory',
        'price',
        'hasSizes',
        'samePriceForAllSizes',
        'stock',
        'image',
    ];



    public function sizes()
    {
        return $this->hasMany(ProductSize::class, 'productId');
    }
}
