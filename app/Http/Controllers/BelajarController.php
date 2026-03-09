<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BelajarController extends Controller
{
    public function index()
    {

        return view('belajar');
    }

    public function getSiswa()
    {
        $title = "Data Siswa";
        $siswa = [
            [
                'nama'  => 'Bambang Pamungkas',
                'nilai' => 100,
            ],
            [
                'nama'  => 'Wahyu Kamal',
                'nilai' => 80,
            ],
            [
                'nama'  => 'Budi Sudarsono',
                'nilai' => 60,
            ]
        ];
        return view('siswa', compact('title', 'siswa'));
    }

    public function create()
    {
        return view('tambah-siswa');
    }

    public function store(Request $request)
    {
        $nama = $request->nama;
        $nilai = $request->nilai;

        $status = $nilai >= 75 ? 'Lulus' : 'Tidak Lulus';

        return "Siswa $nama  dengan nilai $nilai dinyatakan $status";
    }
}
