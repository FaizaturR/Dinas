<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class KelolaAdminController extends Controller
{
    public function index()
    {
        $daftarAdmin = Admin::orderBy('name')->get();
        $totalAdmin = $daftarAdmin->count();

        return view('admin.kelola-admin.index', compact('daftarAdmin', 'totalAdmin'));
    }

    public function store(StoreAdminRequest $request)
    {
        Admin::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
    
        return redirect()->route('admin.kelola-admin.index')->with('success', 'Akun admin berhasil ditambahkan.');
    }
    
    public function update(UpdateAdminRequest $request, Admin $kelolaAdmin)
    {
        $data = [
            'name' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ];
    
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        $kelolaAdmin->update($data);
    
        return redirect()->route('admin.kelola-admin.index')->with('success', 'Akun admin berhasil diperbarui.');
    }

    public function destroy(Admin $kelolaAdmin)
    {
        if ($kelolaAdmin->id === auth()->id()) {
            return redirect()->route('admin.kelola-admin.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        if (Admin::count() <= 1) {
            return redirect()->route('admin.kelola-admin.index')->with('error', 'Minimal harus ada satu akun admin yang tersisa.');
        }

        $kelolaAdmin->delete();

        return redirect()->route('admin.kelola-admin.index')->with('success', 'Akun admin berhasil dihapus.');
    }
}