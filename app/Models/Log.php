<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $primaryKey = 'LogID';

    protected $fillable = [
        'AdminID',
        'action',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'AdminID');
    }
}
