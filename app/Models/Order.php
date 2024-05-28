<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'OrderID';

    protected $fillable = [
        'UserID',
        'order_date',
        'status',
        'total_amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'OrderID');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'OrderID');
    }
}
