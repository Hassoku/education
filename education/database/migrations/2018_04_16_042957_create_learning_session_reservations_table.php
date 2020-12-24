<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLearningSessionReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_session_reservations', function (Blueprint $table) {
            $table->increments('id');

            // student
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

            // tutor
            $table->integer('tutor_id')->unsigned();
            $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');

            // topic
            $table->integer('topic_id')->unsigned();
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');

            // date - YYYY-MM-DD
            $table->date('date');

            // duration, (15, 30, 45, 60)
            $table->integer('duration');

            // start - time - 10:00 AM
//            $table->timestamp('start_time')->nullable($value = true);
            $table->time('start_time')->nullable();

            // end   - time - 11:00 PM
//            $table->timestamp('end_time')->nullable($value = true);
            $table->time('end_time')->nullable();

            // status - 0 = false = off, 1 = true = on
            $table->boolean('status')->default(true);

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
        Schema::dropIfExists('learning_session_reservations');
    }
}
