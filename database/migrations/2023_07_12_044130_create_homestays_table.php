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
            $table->string('ward_code');
            $table->string('address');
            $table->string('preview_image')->nullable();
            $table->string('desc')->nullable();
            $table->boolean('restaurant');
            $table->boolean('free-wifi');
            $table->boolean('pool');
            $table->boolean('spa');
            $table->boolean('bar');
            $table->boolean('breakfast');
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
