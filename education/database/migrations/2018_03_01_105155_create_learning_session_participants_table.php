<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLearningSessionParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_session_participants', function (Blueprint $table) {
            $table->increments('id');

            // learning session
            $table->integer('learning_session_id')->unsigned();
            $table->foreign('learning_session_id')->references('id')->on('learning_sessions')->onDelete('cascade');

            // session type
            // can't null
            $table->enum('type',['individual','grouped'])->default('individual');

            // student
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->string('twilio_student_identity')->default('no_identity'); // created by server for twilio participant

            // tutor
            // in grouped session tutor id will be attached will every student's entry for corresponding session
            $table->integer('tutor_id')->unsigned();
            $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');
            $table->string('twilio_tutor_identity')->default('no_identity'); // created by server for twilio participant

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
        Schema::dropIfExists('learning_session_participants');
    }
}
