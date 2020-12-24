<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_balances', function (Blueprint $table) {
            $table->increments('id');

            // can't null
            $table->enum('type',['individual','grouped'])->default('individual');

            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

            ////////////////////////////////////////////////////////////////////////////
            ///      purchased_slots and purchased_amount is null
            ////////////////////////////////////////////////////////////////////////////

            $table->integer('learning_session_id')->default(0)/*->unsigned()->unique()*/;

            /*
             * - used in session
             * -
             * */
            $table->integer('consumed_slots')->default(0);   // 15sec
            $table->float('consumed_amount')->default(0.0);  // $

            /*
             * ------------------------------------------------------------------
             *      while user end a session with any tutor
             * ------------------------------------------------------------------
             * = remaining_slots =   remaining_slots(oldOne) - consumed_slots
             * = remaining_amount =  remaining_amount(oldOne) - consumed_slots
             *
             * -----------------------------------------------------------------
             *          while student purchase the slots
             * -----------------------------------------------------------------
             * = remaining_slots =  purchased_slots + remaining_slots(oldOne)
             * = remaining_amount =  purchased_amount + remaining_amount(oldOne)
             * */
            $table->integer('remaining_slots')->default(0);   // 15sec
            $table->float('remaining_amount')->default(0.0);  // $


            ///////////////////////////////////////////////////////////////////////////////
            ///  consumed_slots, consumed_amount and learning_session_id is null
            ///////////////////////////////////////////////////////////////////////////////

            $table->integer('purchased_slots')->default(0);   // 15sec
            $table->float('purchased_amount')->default(0.0);  // $
            //
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
        Schema::dropIfExists('student_balances');
    }
}
