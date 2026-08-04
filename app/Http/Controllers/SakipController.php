<?php

namespace App\Http\Controllers;

use App\Models\Sakip;

class SakipController extends Controller
{
    const KATEGORI_LABEL = [
        'renstra_pk' => 'Renstra & Perjanjian Kinerja',
        'lkjip' => 'LKjIP',
        'iku' => 'IKU',
    ];

    public function index(\Illuminate\Http\Request $request)
    {
        $filter = $request->kategori;
        $filter = array_key_exists($filter, self::KATEGORI_LABEL) ? $filter : '';

        $semuaDokumen = Sakip::orderByDesc('tahun')->orderBy('judul')->get();

        $dokumenPerKategori = [
            'renstra_pk' => collect(),
            'lkjip' => collect(),
            'iku' => collect(),
        ];
        foreach ($semuaDokumen as $d) {
            $dokumenPerKategori[$d->kategori]->push($d);
        }

        $kategoriTampil = $filter !== '' ? [$filter => self::KATEGORI_LABEL[$filter]] : self::KATEGORI_LABEL;

        return view('sakip.index', compact('filter', 'kategoriTampil', 'dokumenPerKategori'));
    }
}