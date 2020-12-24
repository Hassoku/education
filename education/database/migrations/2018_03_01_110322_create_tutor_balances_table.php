<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_balances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tutor_id')->unsigned();
            $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');

            // commented: change for withdraw type transaction
            //$table->integer('learning_session_id')->default(0)->unsigned()->unique();

            $table->integer('learning_session_id')->default(0)->unsigned();

            /*
             * while learning_session_id is not null and withdraw_amount is null
             * */
            $table->float('earning_amount')->default(0.0);

            /*
             * while learning_session_is and earning_amount is null
             * */
            $table->float('withdraw_amount')->default(0.0);

            /*
             * transaction type:
             * earning: while tutor ends a session
             * withdraw: while tutor withdraw some amount from his/her account
             * default: will be earning
             * */
            $table->enum('type',['earning','withdraw'])->default('earning');

            // admin
            $table->integer('moderate_id')->unsigned()->default(1); // admin
            $table->foreign('moderate_id')->references('id')->on('admins')->onDelete('cascade');
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
        Schema::dropIfExists('tutor_balances');
    }
}
