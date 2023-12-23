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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('kode_invoice')->nullable();
            $table->foreignId('sale_id')->nullable()->constrained('sales')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['Draft', 'Posted', 'Canceled'])->nullable();
            $table->timestamp('invoice_date')->nullable();
            $table->timestamp('accounting_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
