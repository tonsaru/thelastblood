<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomreq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('roomreqs', function (Blueprint $table) {
                 $table->increments('id');
                 $table->integer('user_id')->unsigned();
                 $table->foreign('user_id')
                       ->references('id')->on('users')
                       ->onDelete('cascade');
                 $table->string('patient_status')->default('not complete');
                 $table->string('patient_id');
                 $table->string('patient_name');
                 $table->string('patient_blood');
                 $table->string('patient_blood_type',8)->default('positive');
                 $table->string('patient_detail');
                 $table->string('patient_province');
                 $table->string('patient_hos');
                 $table->string('patient_hos_la')->defalut('0');
                 $table->string('patient_hos_long')->defalut('0');
                 $table->string('patient_thankyou')->nullable();
                 $table->integer('countblood');
                 $table->integer('count_refresh')->default(1);
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
