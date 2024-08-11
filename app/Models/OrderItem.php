<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['itemName','itemQuantity','itemPrice','itemSize'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
