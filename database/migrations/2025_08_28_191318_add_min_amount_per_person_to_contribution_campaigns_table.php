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
        Schema::table('contribution_campaigns', function (Blueprint $table) {
            $table->decimal('min_amount_per_person', 10, 2)->nullable()->after('target_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contribution_campaigns', function (Blueprint $table) {
            $table->dropColumn('min_amount_per_person');
        });
    }
};
