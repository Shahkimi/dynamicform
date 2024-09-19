<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ptj extends Model
{
    protected $fillable = ['nama_ptj', 'kod_ptj', 'alamat', 'pengarah'];

    // Explicitly define the table name
    protected $table = 'ptj';

    public function bahagians()
    {
        return $this->hasMany(Bahagian::class);
    }
}
