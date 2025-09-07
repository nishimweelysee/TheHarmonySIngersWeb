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
        Schema::create('practice_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practice_session_id')->constrained('practice_sessions')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->enum('status', ['present', 'absent', 'late', 'excused'])->default('absent');
            $table->text('reason')->nullable();
            $table->timestamp('arrival_time')->nullable();
            $table->timestamp('departure_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Ensure unique attendance per member per session
            $table->unique(['practice_session_id', 'member_id']);

            // Indexes for efficient querying
            $table->index(['practice_session_id', 'status']);
            $table->index(['member_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_attendances');
    }
};
