<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_chats', function (Blueprint $table) {
            $table->increments('id');

            // student
            $table->integer('student_id')->unsigned()/*->unique()*/;
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->string('twilio_student_identity')->default('no identity'); // created by server for twilio participant

            // tutor
            $table->integer('tutor_id')->unsigned()/*->unique()*/;
            $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');
            $table->string('twilio_tutor_identity')->default('no identity'); // created by server for twilio participant

            // chat
            $table->string('twilio_chat_channel_unique_name')->nullable($value = true); // chat_channel_unique_name
            $table->string('twilio_chat_channel_friendly_name')->nullable($value = true); // chat_channel_friendly_name
            $table->string('twilio_chat_channel_sid')->nullable($value = true); // chat_channel_sid
            $table->string('twilio_chat_channel_url')->nullable($value = true); // chat_channel_url
            $table->string('twilio_chat_channel_type')->nullable($value = true); // chat_channel_type
            $table->integer('twilio_chat_channel_member_count')->nullable($value = true); // chat_channel_member_count
            $table->integer('twilio_chat_channel_msg_count')->nullable($value = true); // chat_channel_msg_count

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
        Schema::dropIfExists('individual_chats');
    }
}
