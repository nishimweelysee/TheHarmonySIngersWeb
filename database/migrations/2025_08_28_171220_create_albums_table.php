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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['photo', 'video', 'audio', 'mixed']);
            $table->string('cover_image')->nullable();
            $table->foreignId('concert_id')->nullable()->constrained()->onDelete('set null');
            $table->date('event_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_public')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
