<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catagory extends Model
{
    use HasFactory;

    protected $fillable = [
        'catagory_name',
        'catagory_description',
    ];
    public function post(){
        return $this->hasMany(Post::class);
    }
    public function customer(){
        return $this->hasMany(Customer::class);
    }
}
