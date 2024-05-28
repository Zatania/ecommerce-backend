<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'ProductID';

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'product_image',
        'CategoryID',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'ProductID');
    }
}
