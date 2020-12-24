<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorSpecializationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_specializations', function (Blueprint $table) {
            $table->increments('id');
            // tutor profile
            $table->integer('tutor_profile_id')->unsigned();
            $table->foreign('tutor_profile_id')->references('id')->on('tutor_profiles')->onDelete('cascade');

/*            // specialization
            $table->integer('specialization_id')->unsigned();
            $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('cascade');*/

            // topics
            $table->integer('topic_id')->unsigned();
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');

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
        Schema::dropIfExists('tutor_specializations');
    }
}
