<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_preferences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned()->unique('student_id', 'student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

            // language
            $table->enum('language',['English', 'Arabic'])->default('English');

            // time zone
            $table->string('timezone')->default('UTC');

            // desktopNotification
            $table->boolean('desktopNotification')->default(true);

            // emailNotification
            $table->boolean('emailNotification')->default(true);

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
        Schema::dropIfExists('student_preferences');
    }
}
