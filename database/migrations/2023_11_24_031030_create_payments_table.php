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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('kode_payment')->nullable();
            $table->foreignId('bill_id')->nullable()->constrained('bills')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('payment_method', ['Cash', 'Transfer'])->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->string('amount')->nullable();
            $table->string('payment_date')->nullable();
            $table->enum('status', ['Not Paid', 'Paid'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
