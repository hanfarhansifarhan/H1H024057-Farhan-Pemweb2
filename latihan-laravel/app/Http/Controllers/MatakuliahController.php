<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    private function getDataMatakuliah()
    {
        return [
            [
                'kode' => 'PWEB201',
                'nama' => 'Pemrograman Web II',
                'sks' => 3
            ],
            [
                'kode' => 'IOT201',
                'nama' => 'Internet of Things',
                'sks' => 3
            ],
            [
                'kode' => 'BD201',
                'nama' => 'Basis Data',
                'sks' => 3
            ],
            [
                'kode' => 'SM201',
                'nama' => 'Sistem Mikrokontroler',
                'sks' => 2
            ],
            [
                'kode' => 'ARK201',
                'nama' => 'Arsitektur dan Organisasi Komputer',
                'sks' => 3
            ],
        ];
    }

    public function index(Request $request)
    {
        $daftarMatakuliah = $this->getDataMatakuliah();

        $kataKunci = $request->query('q', '');

        if ($kataKunci !== '') {
            $daftarMatakuliah = array_filter(
                $daftarMatakuliah,
                function ($matakuliah) use ($kataKunci) {
                    return stripos($matakuliah['kode'], $kataKunci) !== false
                        || stripos($matakuliah['nama'], $kataKunci) !== false;
                }
            );
        }

        return view('matakuliah.index', [
            'daftarMatakuliah' => $daftarMatakuliah,
            'kataKunci' => $kataKunci
        ]);
    }

    public function show(string $kode)
    {
        $daftarMatakuliah = $this->getDataMatakuliah();

        $matakuliahDipilih = null;

        foreach ($daftarMatakuliah as $matakuliah) {
            if ($matakuliah['kode'] === $kode) {
                $matakuliahDipilih = $matakuliah;
                break;
            }
        }

        if ($matakuliahDipilih === null) {
            abort(404);
        }

        return view('matakuliah.show', [
            'matakuliah' => $matakuliahDipilih
        ]);
    }
}