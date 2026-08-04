<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sakip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()
                ->constrained('admin')->nullOnDelete();
            $table->enum('kategori', ['renstra_pk', 'lkjip', 'iku']);
            $table->string('judul', 200);
            $table->year('tahun');
            $table->string('file');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('sakip');
    }
};
