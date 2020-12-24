<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorCardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_card_details', function (Blueprint $table) {
            $table->increments('id');
            // tutor
            $table->integer('tutor_id')->unsigned()->unique();
            $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');

            // card number
            $table->string('number')->unique();
            // expiry date
            $table->date('expiryDate');
            // Card holder
            $table->string('holder');
            // CVV
            $table->string('cvv');

            /// more fields - if needed
                //
            ///

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
        Schema::dropIfExists('tutor_card_details');
    }
}
