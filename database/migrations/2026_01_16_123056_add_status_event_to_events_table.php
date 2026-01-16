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
        Schema::table('events', function (Blueprint $table) {
            // Membuat kolom enum dengan 3 pilihan status
            $table->enum('status_event', ['upcoming', 'ongoing', 'full'])
                ->default('upcoming')
                ->after('status'); // Meletakkannya setelah kolom status lama
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('status_event');
        });
    }
};
