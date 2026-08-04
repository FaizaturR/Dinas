<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanggapan_pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduan')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admin')->nullOnDelete();
            $table->longText('isi');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('tanggapan_pengaduan');
    }
};
