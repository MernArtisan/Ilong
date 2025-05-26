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
        Schema::create('zoom_meetings', function (Blueprint $table) {
            $table->id(); // auto increment primary key
            $table->string('meeting_id')->unique(); // Unique meeting ID
            $table->string('host_id'); // Host ID
            $table->string('topic'); // Meeting topic
            $table->timestamp('start_time'); // Start time of the meeting
            $table->integer('duration'); // Duration of the meeting in minutes
            $table->string('password')->nullable(); // Password for the meeting
            $table->string('start_url'); // URL to start the meeting
            $table->string('join_url'); // URL to join the meeting
            $table->string('status'); // Meeting status (e.g., "scheduled", "started")
            $table->unsignedBigInteger('professional_id'); // Professional user ID (from the Availability model)
            $table->unsignedBigInteger('user_id'); // User ID (from the authenticated user)
            $table->unsignedBigInteger('availability_id'); // Availability ID (related to the slot)
            $table->timestamps(); // created_at and updated_at
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_meetings');
    }
};
