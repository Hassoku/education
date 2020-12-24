<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLearningSessionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_session_requests', function (Blueprint $table) {
            $table->increments('id');

            // can't null
            $table->enum('type',['individual','grouped'])->default('individual');

            $table->integer('learning_session_id')->unsigned()->nullable($value = true);
            $table->foreign('learning_session_id')->references('id')->on('learning_sessions'); // Session F-K

            $table->string('twilio_room_unique_name');          // twilio_room_unique_name

            $table->integer('tutor_id')->unsigned();
            $table->foreign('tutor_id')->references('id')->on('tutors');                // Tutor F-K

            $table->integer('student_id')->unsigned(); // request_by
            $table->foreign('student_id')->references('id')->on('students');            // Student F-K

            $table->boolean('accepted')->default(false); // if tutor accept
            $table->boolean('request_status')->default(true); // when request will responded by tutor, this will false

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
        Schema::dropIfExists('learning_session_requests');
    }
}
