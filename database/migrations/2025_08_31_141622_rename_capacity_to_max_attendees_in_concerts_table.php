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
            $table->renameColumn('capacity', 'max_attendees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concerts', function (Blueprint $table) {
            $table->renameColumn('max_attendees', 'capacity');
        });
    }
};
