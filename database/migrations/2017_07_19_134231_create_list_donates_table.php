<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListDonatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_donates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('roomreq_id')->unsigned();
            $table->foreign('roomreq_id')
                    ->references('id')->on('roomreqs')
                    ->onDelete('cascade');
            $table->integer('donate_list');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                     ->references('id')->on('users')
                     ->onDelete('cascade');
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
        Schema::dropIfExists('list_donates');
    }
}
