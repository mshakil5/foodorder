<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalItem extends Model
{
    use HasFactory;

    public function additionalitemtitle()
    {
        return $this->belongsTo(AdditionalItemTitle::class);
    }
}
