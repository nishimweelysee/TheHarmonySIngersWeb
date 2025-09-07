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
        // Update all USD contributions to RWF
        DB::table('individual_contributions')
            ->where('currency', 'USD')
            ->update(['currency' => 'RWF']);
            
        // Update all USD contribution campaigns to RWF
        DB::table('contribution_campaigns')
            ->where('currency', 'USD')
            ->update(['currency' => 'RWF']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert RWF contributions back to USD (if needed)
        DB::table('individual_contributions')
            ->where('currency', 'RWF')
            ->update(['currency' => 'USD']);
            
        DB::table('contribution_campaigns')
            ->where('currency', 'RWF')
            ->update(['currency' => 'USD']);
    }
};
