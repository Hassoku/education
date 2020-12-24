<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_availabilities', function (Blueprint $table) {
            $table->increments('id');
            // tutor profile
            $table->integer('tutor_profile_id')->unsigned();
            $table->foreign('tutor_profile_id')->references('id')->on('tutor_profiles')->onDelete('cascade');

            // timings
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            // days
                // if all days are selected(true) than user have scheduled repeat on "Daily" other wise selected option is weekly
            $table->boolean('MON')->default(false);
            $table->boolean('TUE')->default(false);
            $table->boolean('WED')->default(false);
            $table->boolean('THU')->default(false);
            $table->boolean('FRI')->default(false);
            $table->boolean('SAT')->default(false);
            $table->boolean('SUN')->default(false);

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
        Schema::dropIfExists('tutor_availabilities');
    }
}
