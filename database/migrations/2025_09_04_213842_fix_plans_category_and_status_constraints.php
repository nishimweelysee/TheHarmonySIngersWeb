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
        // First, update any invalid category values to valid ones
        DB::table('plans')->where('category', 'workshop')->update(['category' => 'training']);
        DB::table('plans')->where('category', 'workshop')->update(['category' => 'training']);
        
        // Update any old status values to new ones
        DB::table('plans')->where('status', 'planned')->update(['status' => 'draft']);
        DB::table('plans')->where('status', 'in_progress')->update(['status' => 'active']);
        
        // Drop the existing enum constraints and recreate with new values
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['category', 'status']);
        });
        
        Schema::table('plans', function (Blueprint $table) {
            $table->enum('category', ['performance', 'training', 'fundraising', 'community', 'administration', 'workshop'])->default('performance')->after('end_date');
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
        DB::table('plans')->where('category', 'workshop')->update(['category' => 'training']);
        
        // Drop the new enum constraints and recreate with old values
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['category', 'status']);
        });
        
        Schema::table('plans', function (Blueprint $table) {
            $table->enum('category', ['performance', 'training', 'fundraising', 'community', 'administration'])->default('performance')->after('end_date');
            $table->enum('status', ['planned', 'in_progress', 'completed', 'cancelled'])->default('planned')->after('category');
        });
    }
};
