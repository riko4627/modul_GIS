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
        Schema::create('tb_gis_streetfoods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_streetfoods')->constrained('tb_streetfoods');
            $table->string('sub_district');
            $table->string('longitude');
            $table->string('latitude');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_gis_streetfoods');
    }
};
