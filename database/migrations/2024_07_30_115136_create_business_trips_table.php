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
        Schema::create('business_trips', function (Blueprint $table) {
            $table->id();
            $table->string('no');
            $table->string('no_surat');
            $table->string('name');
            $table->string('nik');
            $table->date('start_date');
            $table->date('end_date');
            $table->json('transportation')->nullable();
            $table->json('accommodation')->nullable();
            $table->json('allowance')->nullable();
            $table->decimal('cash_advance_amount', 15, 2)->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->string('status')->default('Waiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_trips');
    }
};
