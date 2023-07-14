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
        Schema::create('visitas', function (Blueprint $table) {
            $table->integer('user_id');
            $table->biginteger('ruc');
            $table->enum('A',[0,1])->default(0);
            $table->enum('F',[0,1])->default(0);
            $table->enum('C',[0,1])->default(0);
            $table->enum('D',[0,1])->default(0);
            $table->enum('P',[0,1])->default(0);
            $table->enum('B',[0,1])->default(0);
            $table->enum('N',[0,1])->default(0);
            $table->enum('R',[0,1])->default(0);
            $table->enum('T',[0,1])->default(0);
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
        Schema::dropIfExists('visitas');
    }
};
