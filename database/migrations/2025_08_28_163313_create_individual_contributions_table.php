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
        Schema::create('individual_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('contribution_campaigns')->onDelete('cascade');
            $table->string('contributor_name');
            $table->string('contributor_email')->nullable();
            $table->string('contributor_phone')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('RWF');
            $table->date('contribution_date');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'check', 'mobile_money', 'other'])->default('cash');
            $table->string('reference_number')->nullable(); // Receipt number, transaction ID, etc.
            $table->enum('status', ['pending', 'confirmed', 'completed'])->default('confirmed');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['campaign_id', 'status']);
            $table->index('contributor_name');
            $table->index('contribution_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual_contributions');
    }
};
