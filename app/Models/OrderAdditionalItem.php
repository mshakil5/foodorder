<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAdditionalItem extends Model
{
    use HasFactory;

    public function orderdetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
