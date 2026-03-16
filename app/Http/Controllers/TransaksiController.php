<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZakatPenerimaan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TransaksiController extends Controller
{
    /**
     * for now simply redirect to rekap list; dashboard already shows latest
     */
    public function index()
    {
        return redirect()->route('admin.rekap');
    }

    /**
     * Show a single transaksi record.  All logged-in roles may view.
     */
    public function show(int $id)
    {
        $record = ZakatPenerimaan::with('creator')->findOrFail($id);
        return view('admin.transaksi-detail', compact('record'));
    }

    /**
     * Update record.  Only admin or kasir may perform.
     */
    public function update(Request $request, int $id)
    {
        // allow admin/ kasir from either guard (admin table or users table)
        $user = auth('admin')->check() ? auth('admin')->user() : auth('web')->user();
        if (! $user || ! in_array($user->role, ['admin', 'kasir'])) {
            abort(403);
        }

        $request->validate([
            'nama'        => 'required|string|max:100',
            'alamat'      => 'nullable|string|max:200',
            'telpon'      => 'nullable|string|max:30',
            'profesi'     => 'nullable|string|max:100',
            'jumlah_jiwa' => 'required|integer|min:1',
            'status'      => ['required', Rule::in(['Lunas', 'Belum Lunas', 'Batal'])],
            'tanggal'     => 'required|date',
            'bukti'       => 'nullable|image|max:2048',
        ]);

        $z = ZakatPenerimaan::findOrFail($id);

        if ($request->hasFile('bukti')) {
            // remove old file if exists
            if ($z->bukti) {
                Storage::disk('public')->delete($z->bukti);
            }
            $z->bukti = $request->file('bukti')->store('bukti', 'public');
        }

        $z->update($request->only([
            'nama',
            'alamat',
            'telpon',
            'profesi',
            'jumlah_jiwa',
            'status',
            'tanggal',
        ]));

        return redirect()->route('admin.transaksi.show', $id)
                         ->with('success', 'Data transaksi berhasil diperbarui.');
    }

    /**
     * Delete record. only admin/ kasir.
     */
    public function destroy(int $id)
    {
        $user = auth('admin')->check() ? auth('admin')->user() : auth('web')->user();
        if (! $user || ! in_array($user->role, ['admin', 'kasir'])) {
            abort(403);
        }

        $z = ZakatPenerimaan::findOrFail($id);
        if ($z->bukti) {
            Storage::disk('public')->delete($z->bukti);
        }
        $z->delete();

        return redirect()->route('admin.transaksi')
                         ->with('success', 'Transaksi berhasil dihapus.');
    }
}
