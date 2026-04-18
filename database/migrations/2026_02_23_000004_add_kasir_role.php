<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update admins table role enum - always has role
        if (Schema::hasColumn('admins', 'role')) {
            DB::statement("ALTER TABLE admins MODIFY role ENUM('admin', 'kasir', 'pengurus') DEFAULT 'pengurus'");
        }

        // Update users table role enum - only if column exists
        if (Schema::hasColumn('users', 'role')) {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'kasir', 'pengurus') DEFAULT 'pengurus'");
        }
    }

    public function down(): void
    {
        // Revert admins table
        if (Schema::hasColumn('admins', 'role')) {
            DB::statement("ALTER TABLE admins MODIFY role ENUM('admin', 'pengurus') DEFAULT 'pengurus'");
        }

        // Revert users table
        if (Schema::hasColumn('users', 'role')) {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'pengurus') DEFAULT 'pengurus'");
        }
    }
};