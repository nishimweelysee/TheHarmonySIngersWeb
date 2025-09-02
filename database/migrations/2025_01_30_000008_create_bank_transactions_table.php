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
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_account_id')->constrained()->onDelete('cascade');
            $table->date('transaction_date');
            $table->string('description');
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['deposit', 'withdrawal', 'transfer', 'fee', 'interest']);
            $table->string('reference_number')->nullable();
            $table->string('check_number')->nullable();
            $table->enum('status', ['pending', 'cleared', 'reconciled'])->default('pending');
            $table->foreignId('journal_entry_id')->nullable()->constrained('journal_entries');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_transactions');
    }
};
