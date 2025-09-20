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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->dateTime('airing_time');
            $table->string('poster_image')->nullable();
            $table->timestamps();
            
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
        Schema::dropIfExists('series');
    }
};
