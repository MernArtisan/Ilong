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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID of the user making the booking
            $table->unsignedBigInteger('professional_id'); // ID of the professional
            $table->unsignedBigInteger('availability_id'); // ID of the availability slot
            $table->date('date'); // Booking date
            $table->string('time_slot'); // Time slot
            $table->text('note')->nullable(); // Optional note
            $table->string('status')->default('scheduled'); // Booking status: scheduled, completed, canceled, disputed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
