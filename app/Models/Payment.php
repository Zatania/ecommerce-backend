<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'PaymentID';

    protected $fillable = [
        'OrderID',
        'payment_date',
        'amount',
        'payment_method',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID');
    }
}
