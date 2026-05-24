<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('qurban_penerimaans', function (Blueprint $table) {
            $table->json('nama_jiwa')->nullable()->after('nama_amil');
            $table->text('catatan')->nullable()->after('nama_jiwa');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('qurban_penerimaans', function (Blueprint $table) {
            $table->dropColumn('nama_jiwa');
            $table->dropColumn('catatan');
            $table->dropSoftDeletes();
        });
    }
};
