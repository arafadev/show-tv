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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('series_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->integer('duration');
            $table->dateTime('airing_time');
            $table->string('thumbnail')->nullable();
            $table->string('video_asset');
            $table->integer('episode_number')->default(1);
            $table->integer('season_number')->default(1);
            $table->timestamps();

            $table->index(['series_id', 'season_number', 'episode_number']);
            $table->index('title');
            $table->fullText(['title', 'description']);
            $table->index('airing_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
