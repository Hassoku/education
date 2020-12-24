<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tutor_id')->unsigned()->unique('tutor_id', 'tutor_profiles_tutor_id');
            $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');
            $table->string('picture')->default('assets/tutor/images/users/default_tutor_image.jpg'); // default image - // will save in "assets/tutor/uploaded-media/profile-pic"
            $table->string('video')->nullable($value = true); // will save in "assets/tutor/uploaded-media/profile-vids"
/*            $table->string('tutoring_style')->nullable($value = true);*/
            $table->string('education')->nullable($value = true);
            $table->integer('moderate_id')->unsigned()->default(1); // admin
            $table->foreign('moderate_id')->references('id')->on('admins')->onDelete('cascade');
            $table->timestamps();
        });

//        /*
//         * Creating a default Tutor Profile
//         * */
//        DB::table('tutor_profiles')->insert(
//            [
//                'tutor_id' => 1,
//                'place_of_birth' => 'Unknown',
//                'date_of_birth' => '00-00-0000',
//                'image' => 'images/users/default_tutor_image.png',
//            ]
//        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutor_profiles');
    }
}
