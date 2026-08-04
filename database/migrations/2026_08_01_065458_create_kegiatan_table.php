<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bidang_id')->constrained('bidang')->restrictOnDelete();
            $table->foreignId('admin_id')->constrained('admin')->restrictOnDelete();
            $table->string('judul', 200);
            $table->string('slug', 220);
            $table->text('deskripsi');
            $table->string('gambar');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['draf', 'terbit'])->default('draf');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};
