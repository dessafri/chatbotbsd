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
        Schema::table('penagihans', function (Blueprint $table) {
            $table->string('bukti_faktur')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penagihans', function (Blueprint $table) {
            $table->dropColumn('bukti_faktur');
        });
    }
};
