<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MahasiswaResource;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function mahasiswa(Request $request, $id)
    {
        $programStudi = ProgramStudi::findOrFail($id);

        $perHalaman = $request->integer('per_halaman', 10);

        $mahasiswa = $programStudi->mahasiswa()
            ->orderBy('nama')
            ->paginate($perHalaman);

        return MahasiswaResource::collection($mahasiswa);
    }
}