<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('disposisi_id');
            $table->date('tanggal');
            $table->time('jam')->nullable();
            $table->text('kegiatan')->nullable();
            $table->text('tempat')->nullable();
            $table->string('pejabat')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('disposisi_id')->references('id')->on('disposisi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agenda');
    }
}
