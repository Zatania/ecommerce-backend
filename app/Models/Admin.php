<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $primaryKey = 'AdminID';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'role'
    ];

    public function logs()
    {
        return $this->hasMany(Log::class, 'AdminID');
    }
}
