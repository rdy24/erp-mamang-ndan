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
        Schema::create('manufacturing_orders', function (Blueprint $table) {
            $table->id();
            $table->string('kode_order')->nullable();
            $table->string('jumlah_order')->nullable();
            $table->foreignId('id_produk')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('id_bom')->references('id')->on('boms')->onDelete('cascade');
            $table->enum('status', ['Draft', 'Confirmed','In-Progress', 'Done'])->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacturing_orders');
    }
};
