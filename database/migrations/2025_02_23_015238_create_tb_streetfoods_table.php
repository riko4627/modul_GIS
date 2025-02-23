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
        Schema::create('tb_streetfoods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name_streetfoods');
            $table->string('address_streetfoods');
            $table->string('phone_streetfoods');
            $table->string('image_streetfoods');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_streetfoods');
    }
};
