<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users (Penulis)
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Relasi ke tabel categories 
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('banner')->nullable();
            $table->longText('content');

            // Kolom pendukung file (opsional jika dibutuhkan)
            $table->string('pdf_file')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string('image')->nullable();

            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
