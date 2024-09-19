<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['bahagian_id', 'unit'];

    public function bahagian()
    {
        return $this->belongsTo(Bahagian::class);
    }
}


