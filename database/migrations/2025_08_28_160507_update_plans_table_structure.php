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
        Schema::table('plans', function (Blueprint $table) {
            // Add missing fields that the controller expects
            $table->decimal('budget', 10, 2)->nullable()->after('estimated_budget');
            $table->text('objectives')->nullable()->after('budget');
            $table->text('activities')->nullable()->after('objectives');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            // Remove added fields
            $table->dropColumn(['budget', 'objectives', 'activities']);
        });
    }
};
