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
        Schema::create('reservacions', function (Blueprint $table) {
            $table->biginteger('id_hotel');
            $table->integer('id_hab');
            $table->string('email_cli');
            $table->date('inicio');
            $table->date('final');
            $table->enum('estado', ['P', 'V', 'A', 'C']);
            $table->string('codigo',10);
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
        Schema::dropIfExists('reservacions');
    }
};
