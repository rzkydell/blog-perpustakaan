<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_informations', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('banner')->nullable();
            $table->text('content');

            $table->enum('type', [
                'profile',
                'service',
                'rule',
                'facility',
                'contact',
                'other'
            ])->default('other');

            $table->enum('status', ['draft', 'published'])->default('draft');

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_informations');
    }
};
