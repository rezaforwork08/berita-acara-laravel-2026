<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerhitunganController extends Controller
{

    public function index()
    {
        return view('balok.lp_balok');
    }

    public function store(Request $request)
    {
        // $_POST['angka1'];
        $angka1 = $request->angka1;
        $angka2 = $request->angka2;
        $operator = $request->operator;

        $hasil = 0;

        switch ($operator) {
            case '+':
                $hasil = $angka1 + $angka2;
                break;
            case '-':
                $hasil = $angka1 - $angka2;
                break;
            case '*':
                $hasil = $angka1 * $angka2;
                break;
            case '/':
                if ($angka2 == 0) {
                    return back()->with('error', 'Tidak bisa dibagi 0!');
                }
                $hasil = $angka1 / $angka2;
                break;
        }
        return view('perhitungan.index', compact('hasil'));
    }

    public function storeLpKubus(Request $request)
    {
        //L = 6*s^2
        $s = $request->sisi;
        $hasil = 6 * $s * $s;

        return view('balok.lp_balok', compact('hasil'));
    }


    public function indexVolKubus()
    {
        return view('kubus.vl_kubus');
    }
    public function storeVolKubus(Request $request)
    {
        $s = $request->sisi;
        $vol = $s * $s * $s;

        return view('kubus.vl_kubus', compact('vol'));
    }
}
