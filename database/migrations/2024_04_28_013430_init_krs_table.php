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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas')->unique();
            $table->timestamps();
        });

        Schema::create('matakuliah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_matakuliah')->unique();
            $table->timestamps();
        });

        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nidn')->unique();
            $table->string('nama_dosen');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nim')->unique();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->unsignedBigInteger('id_kelas');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('id_kelas')->references('id')->on('kelas');
        });

        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_matkul');
            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_dosen');
            $table->time('waktu');
            $table->string('hari');

            $table->timestamps();
            $table->foreign('id_matkul')->references('id')->on('matakuliah');
            $table->foreign('id_kelas')->references('id')->on('kelas');
            $table->foreign('id_dosen')->references('id')->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('matakuliah');
        Schema::dropIfExists('dosen');
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('jadwal');
    }
};
