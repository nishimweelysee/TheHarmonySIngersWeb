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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('expense_category_id')->constrained('expense_categories');
            $table->foreignId('account_id')->constrained('chart_of_accounts');
            $table->decimal('amount', 15, 2);
            $table->date('expense_date');
            $table->enum('payment_method', [
                'cash',
                'check',
                'bank_transfer',
                'credit_card',
                'online'
            ])->default('cash');
            $table->string('reference_number')->nullable();
            $table->enum('status', [
                'draft',
                'pending_approval',
                'approved',
                'paid',
                'cancelled'
            ])->default('draft');
            $table->foreignId('requested_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
