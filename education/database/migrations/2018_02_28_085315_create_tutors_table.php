<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // first name
            $table->string('middle_name')->nullable($value = true); // middle name
            $table->string('last_name'); // last name
            $table->string('mobile');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('active')->default(0);
            $table->boolean('is_percentage')->default(0);
            $table->string('charge')->nullable();
            /* under_review: profile reviewed by admin
             * active: after review admin can active the user
             * suspended: admin can suspend the account
             * block: admin can block the tutor
             * */
            $table->enum('status',['under_review','active','suspended','block'])->default('under_review');
            $table->boolean('online_status')->default(0);
            $table->boolean('isBusy')->default(0);
            $table->string('referral_code')->unique(); /////
            $table->string('last_login_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->integer('moderate_id')->unsigned()->default(1); // admin
            $table->foreign('moderate_id')->references('id')->on('admins')->onDelete('cascade');
            $table->timestamps();
        });

//        /*
//         * Creating a default Studnet
//         * */
//        DB::table('tutors')->insert(
//            [
//                'name' => 'Duroos Tutor',
//                'mobile' => '00000',
//                'email' => 'tutor.duroos@duroos.com',
//                'password' => \Illuminate\Support\Facades\Hash::make('123456'),
//                'active' => 0,
//                'online_status' => 0,
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
        Schema::dropIfExists('tutors');
    }
}
