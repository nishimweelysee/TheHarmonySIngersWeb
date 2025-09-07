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
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_code', 20)->unique();
            $table->string('account_name');
            $table->enum('account_type', [
                'asset',
                'liability',
                'equity',
                'revenue',
                'expense'
            ]);
            $table->enum('account_category', [
                'current_assets',
                'fixed_assets',
                'current_liabilities',
                'long_term_liabilities',
                'equity',
                'operating_revenue',
                'other_revenue',
                'operating_expenses',
                'other_expenses'
            ]);
            $table->text('description')->nullable();
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system_account')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_of_accounts');
    }
};
