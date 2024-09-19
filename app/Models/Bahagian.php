<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahagian extends Model
{
    protected $fillable = ['ptj_id', 'bahagian'];

    // Explicitly define the table name
    protected $table = 'bahagian';

    public function ptj()
    {
        return $this->belongsTo(Ptj::class);
    }


    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}

