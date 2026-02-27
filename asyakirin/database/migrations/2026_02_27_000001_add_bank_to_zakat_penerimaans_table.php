<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zakat_penerimaans', function (Blueprint $table) {
            if (!Schema::hasColumn('zakat_penerimaans', 'bank')) {
                $table->string('bank', 50)->nullable()->after('bukti');
            }
        });
    }

    public function down(): void
    {
        Schema::table('zakat_penerimaans', function (Blueprint $table) {
            if (Schema::hasColumn('zakat_penerimaans', 'bank')) {
                $table->dropColumn('bank');
            }
        });
    }
};
