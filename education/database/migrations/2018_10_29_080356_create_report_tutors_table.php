<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_tutors', function (Blueprint $table) {
            $table->increments('id');

            // tutor
            $table->integer('tutor_id')->unsigned();
            $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');

            // student
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

            // Description
            $table->string('description')->nullable($value = true);

            /*
             * pending: pending / new
             * in-process: admin is working
             * closed: after work done admin will close the report
             * */
            $table->enum('status',['pending','in-process','closed'])->default('pending');

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
        Schema::dropIfExists('report_tutors');
    }
}
