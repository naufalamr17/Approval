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
        Schema::table('ticket_requests', function (Blueprint $table) {
            $table->string('jenis_tiket')->nullable()->after('price');
            $table->time('flight_time_end')->nullable()->after('flight_time');
            $table->string('destination')->nullable()->after('route');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_requests', function (Blueprint $table) {
            $table->dropColumn(['jenis_tiket', 'destination']);
        });
    }
};
