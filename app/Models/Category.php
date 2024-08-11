<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'categoryName',
        'subCategories'
    ];

    // Cast the subCategories attribute to an array
    protected $casts = [
        'subCategories' => 'array',
    ];
}
