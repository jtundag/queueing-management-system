<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionFlowStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_flow_steps', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transaction_flow_id');
            $table->unsignedInteger('step_id');
            
            $table->foreign('transaction_flow_id')
                ->references('id')
                ->on('transaction_flows')
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
        Schema::dropIfExists('transaction_flow_steps');
    }
}
