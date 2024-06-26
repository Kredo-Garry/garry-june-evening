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
        Schema::create('follows', function (Blueprint $table) {
            $table->unsignedBigInteger('follower_id'); // the id of the follower
            $table->unsignedBigInteger('following_id'); // the if of the user being followed

            $table->foreign('follower_id')->references('id')->on('users'); //connect to users table
            $table->foreign('following_id')->references('id')->on('users'); //connect to users table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
