<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zakat_penerimaans', function (Blueprint $table) {
            if (!Schema::hasColumn('zakat_penerimaans', 'created_by')) {
                $table->foreignId('created_by')
                      ->nullable()
                      ->after('tahun')
                      ->constrained('users')
                      ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('zakat_penerimaans', function (Blueprint $table) {
            if (Schema::hasColumn('zakat_penerimaans', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
        });
    }
};