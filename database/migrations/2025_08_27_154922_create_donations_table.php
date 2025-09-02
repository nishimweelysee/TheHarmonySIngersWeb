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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contribution_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('sponsor_id')->nullable()->constrained()->onDelete('set null');
            $table->string('donor_name'); // in case not a member/sponsor
            $table->string('donor_email')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('donation_date');
            $table->enum('payment_method', ['cash', 'check', 'bank_transfer', 'online'])->default('cash');
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
