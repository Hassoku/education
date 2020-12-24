<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_charges', function (Blueprint $table) {
            $table->increments('id');


            $table->integer('learning_session_id')->default(0)->unsigned()->unique();
            $table->foreign('learning_session_id')->references('id')->on('learning_sessions'); // Session F-K

            $table->integer('twilio_call_time')->default(0); // sec
            $table->float('twilio_call_amount')->default(0.0); // $
            $table->float('tutor_payment')->default(0.0); // tutor earnings from session
            $table->float('student_deduction')->default(0.0); // amount $ deducted from student balances
            $table->float('service_charges_received')->default(0.0); // total earning from session but twilio not payed

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
        Schema::dropIfExists('service_charges');
    }
}
