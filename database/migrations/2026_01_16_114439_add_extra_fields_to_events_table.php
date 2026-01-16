<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Menambahkan kolom sesuai kebutuhan data dummy
            $table->string('event_time')->nullable()->after('event_date');
            $table->enum('category', ['workshop', 'discussion', 'exhibition', 'webinar'])->default('workshop')->after('title');
            $table->integer('spots_left')->nullable()->after('registration_link');
            $table->enum('location_type', ['physical', 'online', 'hybrid'])->default('physical')->after('location');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['event_time', 'category', 'spots_left', 'location_type']);
        });
    }
};
