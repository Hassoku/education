<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');

            // topic
            $table->string('topic')->nullable($value = false)->unique();

            // Description
            $table->string('description')->nullable($value = true)->defualt("describe topic here");

            /* PARENT
            ------------------------------------------------------
             =>  parent- id of parent topic
             =>  0 for no parent, mean topic it self is parent
            ------------------------------------------------------
             *
             * */
            $table->integer('parent')->unsigned()->default(0); // parent id
//            $table->foreign('parent')->references('id')->on('topics')->onDelete('cascade'); // self FK

            /* LEVEL
             ------------------------------------------------------
            => Level of topic
                => First Level - 0
                    - parent topics with 0 parent
                => Second Level - 1
                    - child of first level topic parent
                => Third level - 2
                    - child of second level topic parent
                => ....
                => ....
                => ....
             ------------------------------------------------------
             *
             * */
            $table->integer('level')->unsigned()->default(0); // level - default 0 mean first level

            /*
             * activate: admin can activate the topic
             * deactivate: admin can deactivate the topic
             * */
            $table->enum('status',['activate','deactivate'])->default('activate');
            $table->tinyInteger('delete')->default('0');

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
        Schema::dropIfExists('topics');
    }
}
