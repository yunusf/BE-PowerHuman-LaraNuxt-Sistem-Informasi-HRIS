<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('gender')->nullable(); // nullable()-> tidak wajib di isi user
            $table->integer('age')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();

            // foreign key
            $table->bigInteger('team_id')->unsigned(); // unsigned? tidak terdapat - dan +
            $table->bigInteger('role_id')->unsigned();

            // cara lain penghubungan ke table lain menggunakan foreign key
            // $table->foreign('team_id')->references('id')->on('teams');
            // $table->foreign('role_id')->references('id')->on('roles');

            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();

            $table->softdeletes(); // kalau menghapus data supaya tidak benar" hilang dari DB
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
