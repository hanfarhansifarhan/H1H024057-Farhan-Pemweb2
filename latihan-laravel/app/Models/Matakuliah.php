<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'sks',
        'semester',
    ];

    public function mahasiswas()
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'mahasiswa_matakuliah'
        )->withPivot('nilai')->withTimestamps();
    }
}