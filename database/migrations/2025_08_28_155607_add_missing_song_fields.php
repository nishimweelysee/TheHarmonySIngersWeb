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
        Schema::table('songs', function (Blueprint $table) {
            // Add missing fields that the form is trying to save
            $table->string('language')->nullable()->after('genre');
            $table->integer('year_composed')->nullable()->after('language');
            $table->decimal('duration', 5, 2)->nullable()->after('year_composed'); // Changed from duration_minutes
            $table->boolean('is_active')->default(true)->after('notes');
            $table->boolean('is_featured')->default(false)->after('is_active');

            // Update difficulty enum to match form options
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced', 'expert'])->default('intermediate')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            // Remove added fields
            $table->dropColumn(['language', 'year_composed', 'duration', 'is_active', 'is_featured']);

            // Revert difficulty enum
            $table->enum('difficulty', ['easy', 'intermediate', 'advanced'])->default('intermediate')->change();
        });
    }
};
