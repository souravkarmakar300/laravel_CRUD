<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductLogin extends Authenticatable
{
    use HasFactory;
    Protected $table = 'product_logins';
    protected $fillable = [
        'phone_no',
        'password',
    ];
 
}
