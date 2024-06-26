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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('body'); // the comments
            $table->unsignedBigInteger('user_id'); // the owner of the comment
            $table->unsignedBigInteger('post_id'); // the post being commented on
            $table->timestamps();

            //connect this to users table
            $table->foreign('user_id')->references('id')->on('users');

            //connect this to posts table, if the posts is deleted by the owner of the post, the comment will be deleted too ( onDelete('cascade) )
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
