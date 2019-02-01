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
            $table->increments('id');
            $table->integer('department_id')
                ->unsigned();
            $table->string('uuid')
                ->unique();
            $table->string('username')
                ->unique();
            $table->string('first_name');
            $table->string('middle_name')
                ->nullable();
            $table->string('last_name');
            $table->string('gender');
            $table->string('email')
                ->nullable();
            $table->string('password');
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
