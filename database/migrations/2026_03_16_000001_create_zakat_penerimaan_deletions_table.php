<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zakat_penerimaan_deletions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zakat_penerimaan_id')->nullable()->index();
            $table->string('nomor')->nullable()->index();
            $table->json('deleted_data');
            $table->string('deleted_by_guard', 20)->nullable();
            $table->unsignedBigInteger('deleted_by_id')->nullable();
            $table->string('deleted_by_name', 100)->nullable();
            $table->string('deleted_by_role', 20)->nullable();
            $table->timestamp('deleted_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zakat_penerimaan_deletions');
    }
};
