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
        Schema::table('event_participant', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_id');

            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_participant', function (Blueprint $table) {
            $table->dropColumn('payment_id');

            $table->dropForeign('payment_id');
        });
    }
};
