<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentServerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_server', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('server_id');
            $table->timestamps();

            $table->foreign('department_id')
                    ->references('id')
                    ->on('departments')
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
        Schema::dropIfExists('department_server');
    }
}
