<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePemeriksaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->integer('dokter_id');
            $table->integer('apoteker_id')->nullable();
            $table->integer('pasien_id');
            $table->float('tinggi_badan', 8, 2)->nullable();
            $table->float('berat_badan', 8, 2)->nullable();
            $table->float('systole', 8, 2)->nullable();
            $table->float('diastole', 8, 2)->nullable();
            $table->float('heart_rate', 8, 2)->nullable();
            $table->float('respiration_rate', 8, 2)->nullable();
            $table->float('suhu_tubuh', 8, 2)->nullable();
            $table->text('pemeriksaan_dokter')->nullable();
            $table->text('berkas')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemeriksaan');
    }
}
