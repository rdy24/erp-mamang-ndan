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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->nullable()->constrained('purchases')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_bahan')->nullable()->constrained('materials')->onDelete('cascade')->onUpdate('cascade');
            $table->string('jumlah')->nullable();
            $table->string('satuan')->nullable();
            $table->string('harga')->nullable();
            $table->string('total_harga')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
