<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_ratings', function (Blueprint $table) {
            $table->increments('id');
            // tutor profile
            $table->integer('tutor_profile_id')->unsigned();
            $table->foreign('tutor_profile_id')->references('id')->on('tutor_profiles')->onDelete('cascade');

            // student
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

            $table->integer('rating');

            // admin
            $table->integer('moderate_id')->unsigned()->default(1); // default admin is 1
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
        Schema::dropIfExists('tutor_ratings');
    }
}
