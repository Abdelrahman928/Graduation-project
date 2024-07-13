<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function redeemHistory ()
    {
        return $this->hasMany(RedeemHistory::class);
    }
}
