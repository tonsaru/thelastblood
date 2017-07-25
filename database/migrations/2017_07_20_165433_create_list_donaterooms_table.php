<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListDonateroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_donaterooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('no');
            $table->integer('roomreq_id')->unsigned();
            $table->foreign('roomreq_id')
                    ->references('id')->on('roomreqs')
                    ->onDelete('cascade');
            $table->integer('donate_list');
            $table->integer('add');
            $table->integer('remaining');
            $table->string('list_status')->default('not complete');
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
        Schema::dropIfExists('list_donaterooms');
    }
}
