<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zakat_penerimaans', function (Blueprint $table) {
            $table->id();

            // Nomor otomatis: ASY/26/UPZ/0001 — UNIQUE agar tidak duplikat
            $table->string('nomor')->unique();

            // Data Muzakki
            $table->string('nama', 100);
            $table->text('alamat')->nullable();
            $table->string('telpon', 20)->nullable();
            $table->string('profesi', 100)->nullable();
            $table->unsignedTinyInteger('jumlah_jiwa')->default(1);

            // Atas nama disimpan sebagai JSON array
            // ex: ["Ahmad", "Siti", "Rizky"]
            $table->json('atas_nama')->nullable();

            // Item zakat disimpan sebagai JSON array of objects
            // ex: [{"jenis":"Zakat Fitrah","uang":10000,"beras":2}]
            $table->json('items')->nullable();

            // Total
            $table->unsignedBigInteger('total_uang')->default(0);
            $table->decimal('total_beras', 8, 1)->default(0.0);

            // Terbilang — disimpan agar tidak perlu hitung ulang saat cetak ulang
            $table->string('terbilang', 255)->nullable();

            // Amil & tanggal
            $table->string('nama_amil', 100)->nullable();
            $table->date('tanggal');

            // ✅ Status pembayaran
            $table->enum('status', ['Belum Lunas', 'Lunas', 'Batal'])->default('Belum Lunas');

            // 2 digit tahun untuk grouping nomor per tahun (ex: "26")
            $table->char('tahun', 2)->index();

            // ✅ Siapa yang input data (NULL = donatur langsung, ada isi = pengurus/admin)
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zakat_penerimaans');
    }
};