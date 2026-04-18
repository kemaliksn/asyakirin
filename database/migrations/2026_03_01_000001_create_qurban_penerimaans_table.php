<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qurban_penerimaans', function (Blueprint $table) {
            $table->id();

            // Nomor otomatis: ASY/26/QRB/0001 — UNIQUE agar tidak duplikat
            $table->string('nomor')->unique();

            // Data Pembayar Qurban
            $table->string('nama', 100);
            $table->text('alamat')->nullable();
            $table->string('telpon', 20)->nullable();
            $table->string('profesi', 100)->nullable();

            // Item qurban disimpan sebagai JSON array of objects
            // ex: [{"jenis":"Sapi 1/7","keterangan":"330-350kg","uang":3700000}]
            $table->json('items')->nullable();

            // Total
            $table->unsignedBigInteger('total_uang')->default(0);

            // Terbilang — disimpan agar tidak perlu hitung ulang saat cetak ulang
            $table->string('terbilang', 255)->nullable();

            // Amil & tanggal
            $table->string('nama_amil', 100)->nullable();
            $table->date('tanggal');

            // ✅ Status pembayaran
            $table->enum('status', ['Belum Lunas', 'Lunas', 'Batal'])->default('Belum Lunas');

            // 2 digit tahun untuk grouping nomor per tahun (ex: "26")
            $table->char('tahun', 2)->index();

            // ✅ Siapa yang input data (NULL = pembayar langsung, ada isi = pengurus/admin)
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');

            // Bukti pembayaran
            $table->string('bukti')->nullable();

            // Metode pembayaran
            $table->string('bank')->nullable();

            // Daily sequence untuk penomoran harian per petugas
            $table->unsignedTinyInteger('daily_sequence')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qurban_penerimaans');
    }
};
