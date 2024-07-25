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
        Schema::create('ticket_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('poh');
            $table->string('jenis');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('flight_date');
            $table->string('route');
            $table->string('departure_airline');
            $table->time('flight_time');
            $table->string('status');
            $table->integer('price');
            $table->text('remarks')->nullable();
            $table->string('ticket_screenshot');
            $table->string('creator');
            $table->string('status_approval');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_requests');
    }
};
