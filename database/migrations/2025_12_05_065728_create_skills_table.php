<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            // Hubungkan ke tabel users, hapus data jika user dihapus
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Menyimpan array skill, contoh: ["PHP", "Laravel", "React"]
            $table->json('skills');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};