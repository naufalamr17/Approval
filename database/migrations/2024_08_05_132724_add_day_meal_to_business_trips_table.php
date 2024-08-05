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
        Schema::table('business_trips', function (Blueprint $table) {
            $table->integer('day_meal')->after('cash_advance_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_trips', function (Blueprint $table) {
            $table->dropColumn('day_meal');
        });
    }
};
