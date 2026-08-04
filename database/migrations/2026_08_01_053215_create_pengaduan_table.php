<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('email', 150)->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('no_tiket', 20)->unique();
            $table->enum('kategori', ['sarana_prasarana', 'kepegawaian', 'pelayanan', 'lainnya'])
                ->default('lainnya');
            $table->string('judul', 200);
            $table->longText('isi');
            $table->text('lampiran')->nullable();
            $table->enum('status', ['diajukan', 'diproses', 'ditanggapi', 'ditutup'])
                ->default('diajukan');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
