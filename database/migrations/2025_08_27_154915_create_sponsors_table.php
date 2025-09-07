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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // corporate, individual, foundation, government
            $table->string('category')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('sponsorship_level')->nullable(); // platinum, gold, silver, bronze, partner
            $table->decimal('sponsorship_amount', 10, 2)->nullable();
            $table->date('partnership_start_date')->nullable();
            $table->date('partnership_end_date')->nullable();
            $table->decimal('annual_contribution', 10, 2)->nullable();
            $table->string('status')->default('active'); // active, inactive, pending
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
