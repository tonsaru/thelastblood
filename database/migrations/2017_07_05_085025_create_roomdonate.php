<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomdonate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('roomdonates', function (Blueprint $table) {
              $table->increments('id')->unsigned();
              $table->integer('roomreq_id')->unsigned();
              $table->foreign('roomreq_id')
                    ->references('id')->on('roomreqs')
                    ->onDelete('cascade');
              $table->integer('user_id')->unsigned();
              $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
                  // status is accept gived danate
              $table->string('status');
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
        //
    }
}
