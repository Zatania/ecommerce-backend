<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = ['CartID', 'ProductID', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }
}
