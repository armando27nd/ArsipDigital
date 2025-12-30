<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposisi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('parent_disposisi')->nullable();

            $table->text('instruksi_admin')->nullable();
            $table->string('no_dan_tanggal');
            $table->timestamp('waktu_instruksi_admin')->nullable();
            $table->string('file_surat')->nullable();
            $table->integer('no_registrasi');
            $table->date('tanggal');
            $table->string('index_kartu')->nullable();
            $table->text('perihal');
            $table->text('asal');
            $table->text('instruksi')->nullable();
            $table->text('instruksi_user')->nullable();
            $table->text('diteruskan')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['proses', 'disetujui', 'ditolak']);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('parent_disposisi')->references('id')->on('disposisi')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposisi');
    }
}
