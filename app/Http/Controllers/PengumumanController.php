<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function show(string $slug)
    {
        $pengumuman = Pengumuman::where('status', 'terbit')->where('slug', $slug)->first();

        return view('pengumuman.show', compact('pengumuman'));
    }
}