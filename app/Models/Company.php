<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cnpj',
        'email'
    ];

    public function users() 
    {
        return $this->hasMany(User::class);
    }

    public function products() 
    {
        return $this->hasMany(Product::class);
    }
}
