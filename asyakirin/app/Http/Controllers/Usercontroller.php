<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Tampilkan daftar akun pengurus
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Tampilkan form tambah akun
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan akun baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role'     => 'required|in:admin,pengurus',
        ]);

        User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role'      => $validated['role'],
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit akun
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update akun
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'role'     => 'required|in:admin,pengurus',
            'is_active'=> 'required|boolean',
        ]);

        $data = [
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'role'      => $validated['role'],
            'is_active' => $validated['is_active'],
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil diperbarui!');
    }

    /**
     * Hapus akun
     */
    public function destroy(User $user)
    {
        // Cegah hapus akun sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil dihapus!');
    }

    /**
     * Toggle status aktif
     */
    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.users.index')
            ->with('success', "Akun berhasil {$status}!");
    }
}