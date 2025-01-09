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
        Schema::create('penagihans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_order', 255)->nullable();
            $table->string('nama_customer', 255)->nullable();
            $table->char('nomor_handphone', 15)->nullable();
            $table->bigInteger('nilai_faktur')->nullable();
            $table->bigInteger('piutang')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('nomorfaktur', 100)->nullable();
            $table->bigInteger('pembayaran')->nullable();
            $table->dateTime('waktu_upload')->nullable();
            $table->dateTime('waktu_kirim')->nullable();
            $table->string('kode_cabang', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penagihans');
    }
};
