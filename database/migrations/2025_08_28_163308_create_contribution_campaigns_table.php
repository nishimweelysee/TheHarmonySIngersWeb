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
        Schema::create('contribution_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "January 2024 Monthly Contribution"
            $table->text('description')->nullable();
            $table->enum('type', ['monthly', 'project', 'event', 'special'])->default('monthly');
            $table->foreignId('year_plan_id')->nullable()->constrained('plans')->onDelete('set null');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('target_amount', 10, 2)->nullable(); // Goal amount
            $table->decimal('current_amount', 10, 2)->default(0); // Current collected amount
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->string('currency', 3)->default('RWF');
            $table->text('campaign_notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['type', 'status']);
            $table->index(['start_date', 'end_date']);
            $table->index('year_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribution_campaigns');
    }
};
