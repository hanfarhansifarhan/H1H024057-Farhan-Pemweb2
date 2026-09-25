<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';

    protected $fillable = [
        'nim',
        'nama',
        'email',
        'program_studi_id',
        'angkatan',
        'ipk',
        'aktif',
    ];

    protected $casts = [
        'ipk' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function matakuliahs()
    {
        return $this->belongsToMany(
            Matakuliah::class,
            'mahasiswa_matakuliah'
        )->withPivot('nilai')->withTimestamps();
    }
}