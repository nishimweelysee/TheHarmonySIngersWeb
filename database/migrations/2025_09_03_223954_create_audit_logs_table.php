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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event'); // created, updated, deleted, viewed, etc.
            $table->string('auditable_type'); // Model class name
            $table->unsignedBigInteger('auditable_id'); // Model ID
            $table->unsignedBigInteger('user_id')->nullable(); // Who performed the action
            $table->string('user_type')->nullable(); // User model type (User, Member, etc.)
            $table->json('old_values')->nullable(); // Previous values
            $table->json('new_values')->nullable(); // New values
            $table->string('url')->nullable(); // URL where action occurred
            $table->string('ip_address', 45)->nullable(); // IP address
            $table->string('user_agent')->nullable(); // Browser info
            $table->text('description')->nullable(); // Human readable description
            $table->json('metadata')->nullable(); // Additional data
            $table->timestamps();

            // Indexes for better performance
            $table->index(['auditable_type', 'auditable_id']);
            $table->index(['user_id', 'user_type']);
            $table->index('event');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
