<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()
                ->constrained('admin')->nullOnDelete();
            $table->foreignId('kategori_id')->nullable()
                ->constrained('kategori_berita')->nullOnDelete();
            $table->string('judul', 200);
            $table->string('slug', 220)->unique();
            $table->longText('isi');
            $table->string('gambar')->nullable();
            $table->enum('status', ['draf', 'terbit'])->default('draf');
            $table->date('tanggal_publish')->nullable();
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
