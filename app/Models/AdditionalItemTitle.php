<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalItemTitle extends Model
{
    use HasFactory;

    public function additionalitem()
    {
        return $this->hasMany(AdditionalItem::class);
    }
}
