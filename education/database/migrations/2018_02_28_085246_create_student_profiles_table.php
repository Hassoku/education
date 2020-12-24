<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned()->unique('student_id', 'student_profiles_student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->string('picture')->default('assets/student/images/users/default_student_image.jpg'); // default image - // will save in "assets/student/uploaded-media/profile-pic"
            $table->integer('moderate_id')->unsigned()->default(1); // admin
            $table->foreign('moderate_id')->references('id')->on('admins')->onDelete('cascade');
            $table->timestamps();
        });

//        /*
//         * Creating a default Student
//         * */
//        DB::table('student_profiles')->insert(
//            [
//                'student_id' => 1,
//                'place_of_birth' => 'Unknown',
//                'date_of_birth' => '00-00-0000',
//                'image' => 'images/users/default_admin_image.png',
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
        Schema::dropIfExists('student_profiles');
    }
}
