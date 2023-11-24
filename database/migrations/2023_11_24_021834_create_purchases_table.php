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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('kode_purchase')->nullable();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['RFQ', 'Purchase Order'])->default('RFQ');
            $table->enum('bill_status', ['Nothing to Bill', 'Waiting Bills', 'Fully Billed'])->nullable();
            $table->enum('receive_status', ['Waiting', 'Ready', 'Done'])->nullable();
            $table->string('total_harga')->nullable();
            $table->timestamp('order_date')->nullable();
            $table->timestamp('confirm_date')->nullable();
            $table->timestamp('receive_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
