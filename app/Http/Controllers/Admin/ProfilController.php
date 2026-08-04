<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfilRequest;
use App\Models\Profil;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function edit()
    {
        $profil = Profil::first();

        if (! $profil) {
            $profil = Profil::create([]);
        }

        return view('admin.profil.edit', compact('profil'));
    }

    public function update(UpdateProfilRequest $request)
    {
        $profil = Profil::first() ?? new Profil();
    
        $data = $request->validated();
    
        if ($request->hasFile('struktur_organisasi')) {
            if ($profil->struktur_organisasi) {
                Storage::disk('public')->delete($profil->struktur_organisasi);
            }
            $data['struktur_organisasi'] = $request->file('struktur_organisasi')->store('profil', 'public');
        }
    
        $profil->update($data);
    
        return redirect()->route('admin.profil.edit')->with('success', 'Profil instansi berhasil disimpan.');
    }
}