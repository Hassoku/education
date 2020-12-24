<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLearningSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_sessions', function (Blueprint $table) {
            $table->increments('id');

            // can't null
            $table->enum('type',['individual','grouped'])->default('individual');

            // commented: cause moved to learning_session_participants_table
            /*            $table->integer('student_id')->unsigned();
                        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                        $table->string('twilio_student_identity')->default('no identity'); // created by server for twilio participant*/



            // commented: cause moved to learning_session_participants_table
            /*            $table->integer('tutor_id')->unsigned();
                        $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');
                        $table->string('twilio_tutor_identity')->default('no identity'); // created by server for twilio participant*/

            // video
            $table->string('twilio_room_sid')->nullable($value = true); // sid
            $table->string('twilio_room_type')->nullable($value = true); // type(peer-to-peer / group)
            $table->string('twilio_room_status')->nullable($value = true); // status(in-process / completed)
            $table->string('twilio_room_unique_name')->nullable($value = true); // unique_name (roomName_XXX)
            $table->string('twilio_room_duration')->nullable($value = true); // duration (Secs)
            $table->string('twilio_room_url')->nullable($value = true); // url (https://video.twilio.com/v1/Rooms/RMXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
            // chat
            $table->string('twilio_chat_channel_unique_name')->nullable($value = true); // chat_channel_unique_name
            $table->string('twilio_chat_channel_friendly_name')->nullable($value = true); // chat_channel_friendly_name
            $table->string('twilio_chat_channel_sid')->nullable($value = true); // chat_channel_sid
            $table->string('twilio_chat_channel_url')->nullable($value = true); // chat_channel_url
            $table->string('twilio_chat_channel_type')->nullable($value = true); // chat_channel_type
            $table->integer('twilio_chat_channel_member_count')->nullable($value = true); // chat_channel_member_count
            $table->integer('twilio_chat_channel_msg_count')->nullable($value = true); // chat_channel_msg_count

            $table->integer('consumed_time')->default(0);   // sec
            $table->integer('consumed_slot')->default(0);   // 15sec
            $table->float('consumed_amount')->default(0.0); // total amount of session will deducted from student account
            $table->integer('moderate_id')->unsigned()->default(1); // admin
            $table->foreign('moderate_id')->references('id')->on('admins')->onDelete('cascade');
            $table->timestamp('start_time')->useCurrent();
            $table->timestamp('end_time')->useCurrent();
            $table->boolean('status')->default(true); // true(started) false(ended)
            $table->timestamps();
        });

//        /*
//         * Creating a default Learning Session
//         * */
//        DB::table('learning_sessions')->insert(
//            [
//                'student_id' => 1,
//                'tutor_id' => 1,
//                'status' => false,
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
        Schema::dropIfExists('learning_sessions');
    }
}
