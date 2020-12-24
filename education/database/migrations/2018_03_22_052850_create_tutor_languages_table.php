<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_languages', function (Blueprint $table) {
            $table->increments('id');
            // tutor profile
            $table->integer('tutor_profile_id')->unsigned();
            $table->foreign('tutor_profile_id')->references('id')->on('tutor_profiles')->onDelete('cascade');
            // language
            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
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
        Schema::dropIfExists('tutor_languages');
    }
}
