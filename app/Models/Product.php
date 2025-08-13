<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'price',
        'stock_quantity'
    ];

    public function company() 
    {
        return $this->belongsTo(Company::class);
    }
}
