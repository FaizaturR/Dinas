<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil', function (Blueprint $table) {
            $table->id();
            $table->string('selayang_pandang')->nullable();
            $table->string('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('profil');
    }
};
