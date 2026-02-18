<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Tampilkan semua akun (dari tabel admins + users)
     */
    public function index()
    {
        // Ambil dari tabel admins
        $admins = Admin::orderBy('created_at', 'desc')->get()->map(function ($a) {
            $a->source = 'admins'; // tandai dari tabel mana
            return $a;
        });

        // Ambil dari tabel users (role admin/pengurus saja)
        $users = User::whereIn('role', ['admin', 'pengurus'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($u) {
                $u->source = 'users';
                return $u;
            });

        // Gabungkan dan urutkan by created_at
        $allAccounts = $admins->concat($users)
            ->sortByDesc('created_at')
            ->values();

        // Manual pagination
        $perPage     = 15;
        $currentPage = (int) request()->get('page', 1);
        $total       = $allAccounts->count();
        $items       = $allAccounts->forPage($currentPage, $perPage)->values();

        return view('admin.users.index', compact('items', 'total', 'currentPage', 'perPage'));
    }

    /**
     * Form tambah akun baru
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan akun baru ke tabel admins
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => [
                'required', 'email',
                // Email harus unik di kedua tabel
                function ($attribute, $value, $fail) {
                    if (Admin::where('email', $value)->exists()) {
                        $fail('Email sudah digunakan.');
                    }
                    if (User::where('email', $value)->exists()) {
                        $fail('Email sudah digunakan.');
                    }
                },
            ],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role'     => 'required|in:admin,pengurus',
            'tabel'    => 'required|in:admins,users', // pilih simpan ke tabel mana
        ]);

        if ($request->tabel === 'admins') {
            Admin::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => $request->role,
                'is_active' => true,
            ]);
        } else {
            User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => $request->role,
                'is_active' => true,
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil ditambahkan!');
    }

    /**
     * Form edit akun — deteksi otomatis dari tabel mana
     */
    public function edit(Request $request, $id)
    {
        $source = $request->get('source', 'admins');

        if ($source === 'users') {
            $user = User::findOrFail($id);
            $user->source = 'users';
        } else {
            $user = Admin::findOrFail($id);
            $user->source = 'admins';
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update akun
     */
    public function update(Request $request, $id)
    {
        $source = $request->get('source', 'admins');
        $model  = $source === 'users' ? User::findOrFail($id) : Admin::findOrFail($id);
        $table  = $source === 'users' ? 'users' : 'admins';

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => [
                'required', 'email',
                function ($attribute, $value, $fail) use ($id, $source, $model) {
                    // Cek duplikat di admins (kecuali diri sendiri)
                    $adminQuery = Admin::where('email', $value);
                    if ($source === 'admins') $adminQuery->where('id', '!=', $id);
                    if ($adminQuery->exists()) $fail('Email sudah digunakan.');

                    // Cek duplikat di users (kecuali diri sendiri)
                    $userQuery = User::where('email', $value);
                    if ($source === 'users') $userQuery->where('id', '!=', $id);
                    if ($userQuery->exists()) $fail('Email sudah digunakan.');
                },
            ],
            'password'  => ['nullable', 'confirmed', Password::min(8)],
            'role'      => 'required|in:admin,pengurus',
            'is_active' => 'required|boolean',
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'is_active' => $request->is_active,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $model->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil diperbarui!');
    }

    /**
     * Hapus akun
     */
    public function destroy(Request $request, $id)
    {
        $source       = $request->get('source', 'admins');
        $model        = $source === 'users' ? User::findOrFail($id) : Admin::findOrFail($id);
        $currentUser  = auth('admin')->check() ? auth('admin')->user() : auth('web')->user();

        // Cegah hapus akun sendiri
        if ($model->id === $currentUser->id && $source === (auth('admin')->check() ? 'admins' : 'users')) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $model->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil dihapus!');
    }

    /**
     * Toggle status aktif
     */
    public function toggleActive(Request $request, $id)
    {
        $source = $request->get('source', 'admins');
        $model  = $source === 'users' ? User::findOrFail($id) : Admin::findOrFail($id);

        $model->update(['is_active' => !$model->is_active]);

        $status = $model->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.users.index')
            ->with('success', "Akun berhasil {$status}!");
    }
}
