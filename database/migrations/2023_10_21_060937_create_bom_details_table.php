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
        Schema::create('bom_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_bahan')->references('id')->on('materials')->onDelete('cascade');
            $table->foreignId('id_bom')->references('id')->on('boms')->onDelete('cascade');
            $table->string('jumlah');
            $table->string('satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_details');
    }
};
