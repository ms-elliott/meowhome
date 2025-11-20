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
        Schema::dropIfExists('messages');
        
        Schema::create('messages', function (Blueprint $table) {
            $table->id()->increments('id');
            $table->foreignId('post_id')->constrained();
            $table->unsignedBigInteger('applied_user_id');
            $table->foreign('applied_user_id')->references('id')->on('users');
            $table->integer('sent_by');
            $table->integer('sent_to');
            $table->text('message');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
