<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahagian extends Model
{
    protected $fillable = ['ptj_id', 'bahagian'];

    public function ptj()
    {
        return $this->belongsTo(Ptj::class);
    }


    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}

