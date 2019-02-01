<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerStepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_step', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('server_id');
            $table->unsignedInteger('step_id');
            $table->timestamps();

            $table->foreign('server_id')
                ->references('id')
                ->on('servers')
                ->onDelete('cascade');

            $table->foreign('step_id')
                ->references('id')
                ->on('steps')
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
        Schema::dropIfExists('server_step');
    }
}
