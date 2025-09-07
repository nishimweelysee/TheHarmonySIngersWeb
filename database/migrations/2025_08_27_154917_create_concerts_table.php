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
        Schema::create('concerts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->datetime('concert_date');
            $table->string('venue');
            $table->text('venue_address')->nullable();
            $table->enum('status', ['upcoming', 'completed', 'cancelled'])->default('upcoming');
            $table->decimal('ticket_price', 8, 2)->nullable();
            $table->integer('expected_attendance')->nullable();
            $table->text('program_notes')->nullable();
            $table->string('featured_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concerts');
    }
};
