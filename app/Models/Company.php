<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone_number', 'type'];

    public function users() 
    {
        return $this->hasMany(User::class);
    }

    public function products() 
    {
        return $this->hasMany(Product::class);
    }
}
