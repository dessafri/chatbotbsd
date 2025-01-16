<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('penagihans', function (Blueprint $table) {
            // Add the dear_text column with TEXT type
            $table->string('dear_text')->nullable();// Specify the correct column after which to add
            $table->text('message')->nullable();// Specify the correct column after which to add
            $table->date('tgl_faktur')->nullable();// Specify the correct column after which to add
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penagihans', function (Blueprint $table) {
            // Drop the dear_text column
            $table->dropColumn('dear_text');
            $table->dropColumn('message');
            $table->dropColumn('tgl_faktur');
        });
    }
};
