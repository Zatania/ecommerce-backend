<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'CartID';

    protected $fillable = ['UserID'];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'CartID');
    }
}
