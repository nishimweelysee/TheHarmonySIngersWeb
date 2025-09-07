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
        Schema::table('audit_logs', function (Blueprint $table) {
            // Make auditable_type and auditable_id nullable
            $table->string('auditable_type')->nullable()->change();
            $table->unsignedBigInteger('auditable_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            // Revert back to NOT NULL (this will fail if there are NULL values)
            $table->string('auditable_type')->nullable(false)->change();
            $table->unsignedBigInteger('auditable_id')->nullable(false)->change();
        });
    }
};
