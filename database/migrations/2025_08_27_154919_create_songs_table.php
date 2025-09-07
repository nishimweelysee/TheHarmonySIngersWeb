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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('composer')->nullable();
            $table->string('arranger')->nullable();
            $table->string('genre')->nullable();
            $table->enum('difficulty', ['easy', 'intermediate', 'advanced'])->default('intermediate');
            $table->text('lyrics')->nullable();
            $table->string('key_signature')->nullable();
            $table->string('time_signature')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->string('sheet_music_file')->nullable();
            $table->string('audio_file')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
