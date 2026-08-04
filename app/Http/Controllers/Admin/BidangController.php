<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBidangRequest;
use App\Models\Bidang;
use App\Models\Pegawai;

class BidangController extends Controller
{
    public function index()
    {
        $bidang = Bidang::withCount(['pegawai' => function ($q) {
                $q->where('status', 'aktif');
            }])
            ->oldest()
            ->get();

        $totalBidang = $bidang->count();
        $totalPegawai = Pegawai::where('status', 'aktif')->count();
        $rataRata = $totalBidang > 0 ? round($totalPegawai / $totalBidang) : 0;

        return view('admin.bidang.index', compact('bidang', 'totalBidang', 'totalPegawai', 'rataRata'));
    }

    public function store(StoreBidangRequest $request)
    {
        Bidang::create($request->validated());

        return redirect()->route('admin.bidang.index')->with('success', 'Bidang berhasil ditambahkan.');
    }

    public function update(StoreBidangRequest $request, Bidang $bidang)
    {
        $bidang->update($request->validated());

        return redirect()->route('admin.bidang.index')->with('success', 'Bidang berhasil diperbarui.');
    }

    public function destroy(Bidang $bidang)
    {
        if ($bidang->pegawai()->where('status', 'aktif')->exists()) {
            return redirect()->route('admin.bidang.index')
                ->with('error', 'Bidang tidak bisa dihapus karena masih memiliki pegawai aktif.');
        }

        $bidang->delete();

        return redirect()->route('admin.bidang.index')->with('success', 'Bidang berhasil dihapus.');
    }
}