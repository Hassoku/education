<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // first name
            $table->string('middle_name')->nullable($value = true); // middle name
            $table->string('last_name'); // last name
            $table->string('mobile')->nullable();
            $table->string('email')->unique()->nullable();;
            $table->string('password')->nullable();
            $table->string('social_id')->nullable();
            $table->string('google_social_id')->nullable();

            // commented: cause of activation by email
             //$table->boolean('active')->default(0); // un usable

            // use for activation by email
            $table->boolean('activated')->default(0); // un usable
            $table->string('activation_code')->nullable();
            $table->timestamp('activated_at')->nullable();


            /* under_review: profile reviewed by admin
             * active: after review admin can active the user
             * suspended: admin can suspend the account
             * block: admin can block the student
             * */
            $table->enum('status',['under_review','active','suspended','block'])->default('under_review');
            $table->boolean('online_status')->default(0);
            $table->string('referral_code')->unique(); /////
            $table->string('last_login_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('students');
    }
}
