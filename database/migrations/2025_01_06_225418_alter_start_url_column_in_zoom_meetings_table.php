<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('zoom_meetings', function (Blueprint $table) {
            $table->string('start_url', 1024)->change(); // Update length if needed
        });
    }

    public function down()
    {
        Schema::table('zoom_meetings', function (Blueprint $table) {
            $table->string('start_url', 255)->change(); // Revert back to original length if needed
        });
    }
};
