<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bidang_id')->nullable()
                ->constrained('bidang')->nullOnDelete();
            $table->string('nama', 150);
            $table->string('nip', 30)->nullable()->unique();
            $table->string('jabatan', 150);
            $table->string('foto')->nullable();
            $table->string('email', 150)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
