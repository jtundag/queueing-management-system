<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePredefinedFlowTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predefined_flow_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('flow_id');
            $table->unsignedInteger('tag_id');

            $table->foreign('flow_id')
                ->references('id')
                ->on('predefined_flows')
                ->onDelete('cascade');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
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
        Schema::dropIfExists('predefined_flow_tag');
    }
}
