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
        Schema::create('posts', function (Blueprint $table) {
            $table->id()->increments('id');
            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->text('body');
            $table->integer('status')->comment('0:募集中、1:検討中、2:トライアル中、3:募集終了、4:里親決定済');
            $table->integer('age_year')->default(0);
            $table->integer('age_month')->default(0);
            $table->integer('gender')->comment('0:オス、1:メス');
            $table->foreignId('location_id')->constrained();
            $table->foreignId('breed_id')->constrained()->nullable()->default(null);
            $table->foreignId('pattern_id')->constrained()->nullable()->default(null);
            $table->integer('vaccined')->comment('ワクチン接種')->default(0);
            $table->integer('neutered')->comment('去勢/避妊手術')->default(0);
            $table->integer('accept_single')->default(0);
            $table->integer('accept_senior')->default(0);
            $table->integer('accept_location1')->nullable();
            $table->integer('accept_location2')->nullable();
            $table->integer('accept_location3')->nullable();
            $table->integer('accept_location4')->nullable();
            $table->integer('accept_location5')->nullable();
            $table->string('photo1');
            $table->string('photo2')->nullable();
            $table->string('photo3')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
