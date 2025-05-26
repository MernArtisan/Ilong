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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ya professional_profile_id agar profile table hai
            $table->string('license_name');        // License ka naam
            $table->string('license_id');          // License ID
            $table->date('from');                  // Start date
            $table->date('to');                    // Expiry date
            $table->string('license_image');       // License ki image ya PDF
            $table->timestamps();                  // Timestamps (created_at, updated_at)

            // Foreign key taake user ke saath link ho
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
