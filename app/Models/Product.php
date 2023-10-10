<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function assignproduct()
    {
        return $this->hasMany(AssignProduct::class);
    }

    public function additionalItems()
    {
        return $this->belongsToMany(AdditionalItem::class, 'assign_products');
    }

    public function additionalItemTitles()
    {
        return $this->hasManyThrough(
            AdditionalItemTitle::class,
            AdditionalItem::class,
            'product_id',
            'additional_item_id',
            'id',
            'additional_item_title_id'
        );
    }

    
}
