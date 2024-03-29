<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    public function orderadditionalitem()
    {
        return $this->hasMany(OrderAdditionalItem::class);
    }

    public function order()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
