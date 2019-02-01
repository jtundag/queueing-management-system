<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkippedQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skipped_queues', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('server_id');
            $table->unsignedInteger('queue_id');
            $table->timestamps();

            $table->foreign('server_id')
                ->references('id')
                ->on('servers')
                ->onDelete('cascade');

            $table->foreign('queue_id')
                ->references('id')
                ->on('queues')
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
        Schema::dropIfExists('skipped_queues');
    }
}
