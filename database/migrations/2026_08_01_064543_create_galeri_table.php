<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()
                ->constrained('admin')->nullOnDelete();
            $table->string('judul', 200);
            $table->enum('kategori', ['foto', 'prestasi'])->default('foto');
            $table->string('gambar');
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};
