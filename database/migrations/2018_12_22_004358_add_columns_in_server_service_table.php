<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInServerServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('server_service', function (Blueprint $table) {
            $table->unsignedInteger('server_id');
            $table->unsignedInteger('service_id');

            $table->foreign('server_id')
                    ->references('id')
                    ->on('servers')
                    ->onDelete('cascade');

            $table->foreign('service_id')
                    ->references('id')
                    ->on('services')
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
        Schema::table('server_service', function (Blueprint $table) {
            //
        });
    }
}
