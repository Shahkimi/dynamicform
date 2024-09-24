<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['bahagian_id', 'unit'];

    // Explicitly define the table name
    protected $table = 'unit';

    public function bahagian()
    {
        return $this->belongsTo(Bahagian::class);
    }

    // If you need to access PTJ directly from Unit
    public function ptj()
    {
        return $this->belongsTo(Ptj::class, 'bahagian_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($unit) {
            // Add any additional cleanup logic here if needed
        });
    }
}
