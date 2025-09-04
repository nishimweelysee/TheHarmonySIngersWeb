<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing records to match new enum values
        DB::table('plans')->where('status', 'planned')->update(['status' => 'draft']);
        DB::table('plans')->where('status', 'in_progress')->update(['status' => 'active']);

        // Drop the existing enum constraint and recreate with new values
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft')->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update records back to old enum values
        DB::table('plans')->where('status', 'draft')->update(['status' => 'planned']);
        DB::table('plans')->where('status', 'active')->update(['status' => 'in_progress']);

        // Drop the new enum constraint and recreate with old values
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->enum('status', ['planned', 'in_progress', 'completed', 'cancelled'])->default('planned')->after('category');
        });
    }
};
