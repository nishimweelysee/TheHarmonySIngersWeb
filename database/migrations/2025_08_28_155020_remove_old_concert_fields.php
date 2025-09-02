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
        Schema::table('concerts', function (Blueprint $table) {
            // Remove old columns that are no longer used
            $table->dropColumn([
                'concert_date',
                'venue_address',
                'expected_attendance',
                'program_notes',
                'featured_image'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concerts', function (Blueprint $table) {
            // Re-add the old columns if we need to rollback
            $table->datetime('concert_date')->nullable();
            $table->text('venue_address')->nullable();
            $table->integer('expected_attendance')->nullable();
            $table->text('program_notes')->nullable();
            $table->string('featured_image')->nullable();
        });
    }
};
