<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('blood',2);
            $table->string('blood_type',8)->default('positive');
            $table->integer('birthyear');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone',10)->unique();
            $table->string('province');
            $table->integer('countdonate')->default(0);
            $table->string('img')->nullable();
            $table->timestamp('last_date_donate')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->string('status')->default('ready');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
