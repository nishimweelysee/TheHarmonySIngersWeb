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
            // Add new columns
            $table->date('date')->nullable()->after('description');
            $table->time('time')->nullable()->after('date');
            $table->enum('type', ['regular', 'special', 'festival', 'competition'])->default('regular')->after('time');
            $table->integer('capacity')->nullable()->after('ticket_price');
            $table->boolean('is_featured')->default(false)->after('capacity');
        });

        // Update status enum separately (SQLite limitation)
        Schema::table('concerts', function (Blueprint $table) {
            $table->string('status')->default('upcoming')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concerts', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['date', 'time', 'type', 'capacity', 'is_featured']);

            // Revert status enum
            $table->enum('status', ['upcoming', 'completed', 'cancelled'])->default('upcoming')->change();
        });
    }
};
