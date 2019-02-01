<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonnelServerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnel_server', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('personnel_id');
            $table->unsignedInteger('server_id');

            $table->foreign('personnel_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->foreign('server_id')
                ->references('id')
                ->on('servers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personnel_server');
    }
}
