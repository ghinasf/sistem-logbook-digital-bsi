<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke Tabel Guest
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    // Relasi ke Tabel Purpose
    public function purpose()
    {
        return $this->belongsTo(Purpose::class);
    }
}
