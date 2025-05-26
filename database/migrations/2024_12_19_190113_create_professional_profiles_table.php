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
        Schema::create('professional_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key for the user
            $table->string('professional_field')->nullable(); // Professional Field
            $table->string('education_degrees')->nullable(); // Education Degree(s)
            $table->string('certifications')->nullable(); // Certifications
            $table->string('credentials')->nullable(); // Path to uploaded credentials
            $table->string('skills')->nullable(); // Skills
            $table->string('languages')->nullable(); // Languages Spoken
            $table->string('website')->nullable(); // Website
            $table->text('about')->nullable(); // About section
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_profiles');
    }
};
