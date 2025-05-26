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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('role');
            $table->string('country')->nullable()->after('phone');
            $table->string('state_city')->nullable()->after('country');
            $table->string('zip')->nullable()->after('state_city');
            $table->enum('login_status', ['pending', 'approve', 'reject'])->default('pending')->after('zip'); // Add login_status
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
