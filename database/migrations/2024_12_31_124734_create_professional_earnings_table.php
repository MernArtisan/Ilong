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
        Schema::create('professional_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained('users')->onDelete('cascade'); // Foreign key to the users table
            $table->decimal('earning_amount', 8, 2); // Amount earned
            $table->date('earning_date'); // Date of earning
            $table->enum('status', ['pending', 'paid'])->default('pending'); // Status of payment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_earnings');
    }
};
