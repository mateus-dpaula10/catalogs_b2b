<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'company_id',
        'category_id',
        'brand_id'
    ];

    public function company() 
    {
        return $this->belongsTo(Company::class);
    }

    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

    public function brand() 
    {
        return $this->belongsTo(Brand::class);
    }

    public function images() 
    {
        return $this->hasMany(ProductImage::class);
    }

    public function mainImage() 
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }
}
