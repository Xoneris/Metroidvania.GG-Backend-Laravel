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
        Schema::create('api_game', function (Blueprint $table) {
            // Basic info of the Game
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('developer');
            $table->string('publisher');
            $table->string('release_window')->nullable();
            $table->date('release_date')->nullable()->default(NULL);
            $table->text('description');
            // Demo, EA, Kickstarter info
            $table->boolean('demo');
            $table->boolean('earlyaccess');
            $table->string('kickstarter_page')->nullable();
            $table->string('kickstarter_status')->nullable();
            $table->string('trailer');
            // Social Media of a Game 
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('youtube')->nullable();
            $table->string('discord')->nullable();
            $table->string('homepage')->nullable();
            // Platforms the Game is available on
            $table->string('steam')->nullable();
            $table->string('epic')->nullable();
            $table->string('gog')->nullable();
            $table->string('playstation')->nullable();
            $table->string('xbox')->nullable();
            $table->string('nintendo')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_game');
    }
};
