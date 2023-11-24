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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bill')->nullable();
            $table->foreignId('purchase_id')->nullable()->constrained('purchases')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['New','Draft', 'Posted', 'Canceled'])->nullable();
            $table->timestamp('bill_date')->nullable();
            $table->timestamp('accounting_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
