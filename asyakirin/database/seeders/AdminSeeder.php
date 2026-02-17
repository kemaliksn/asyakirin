<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus dulu kalau sudah ada (agar tidak duplikat saat re-seed)
        DB::table('users')->where('email', 'admin@zis.com')->delete();

        DB::table('users')->insert([
            'name'              => 'Admin Ahmad',
            'email'             => 'admin@zis.com',
            'password'          => Hash::make('admin123'),
            'email_verified_at' => now(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $this->command->info('✅ Akun admin berhasil dibuat:');
        $this->command->info('   Email    : admin@zis.com');
        $this->command->info('   Password : admin123');
        $this->command->warn('   ⚠️  Ganti password setelah login pertama!');
    }
}