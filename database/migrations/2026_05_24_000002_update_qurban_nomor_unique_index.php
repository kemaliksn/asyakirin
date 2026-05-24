<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('qurban_penerimaans', function (Blueprint $table) {
            $table->dropUnique(['nomor']);
            $table->unique(['nomor', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::table('qurban_penerimaans', function (Blueprint $table) {
            $table->dropUnique(['nomor', 'deleted_at']);
            $table->unique('nomor');
        });
    }
};
