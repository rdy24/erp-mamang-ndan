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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('kode_vendor')->nullable();
            $table->string('name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->string('position')->nullable();
            $table->enum('type', ['individual', 'company'])->default('company');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
