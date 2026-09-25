<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matakuliah;

class MatakuliahSeeder extends Seeder
{
    public function run(): void
    {
        Matakuliah::create([
            'kode' => 'PWEB201',
            'nama' => 'Pemrograman Web II',
            'sks' => 3,
            'semester' => 3,
        ]);

        Matakuliah::create([
            'kode' => 'IOT201',
            'nama' => 'Internet of Things',
            'sks' => 3,
            'semester' => 3,
        ]);

        Matakuliah::create([
            'kode' => 'BD201',
            'nama' => 'Basis Data',
            'sks' => 3,
            'semester' => 3,
        ]);

        Matakuliah::create([
            'kode' => 'SM201',
            'nama' => 'Sistem Mikrokontroler',
            'sks' => 2,
            'semester' => 3,
        ]);

        Matakuliah::create([
            'kode' => 'ARK201',
            'nama' => 'Arsitektur dan Organisasi Komputer',
            'sks' => 3,
            'semester' => 3,
        ]);
    }
}