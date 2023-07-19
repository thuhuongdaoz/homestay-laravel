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
        Schema::create('homestays', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->integer('location_id');
            $table->string('address');
            $table->string('avatar');
            $table->text('images');
            $table->string('desc');
//            $table->boolean('restaurant');
//            $table->boolean('free_wifi');
//            $table->boolean('pool');
//            $table->boolean('spa');
//            $table->boolean('bar');
//            $table->boolean('breakfast');
            $table->string('utilities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homestays');
    }
};
