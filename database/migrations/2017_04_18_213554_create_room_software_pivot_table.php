<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomSoftwarePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_software', function (Blueprint $table) {
            $table->integer('room_id')->unsigned()->index();
            $table->foreign('room_id')->references('id')->on('room')->onDelete('cascade');
            $table->integer('software_id')->unsigned()->index();
            $table->foreign('software_id')->references('id')->on('software')->onDelete('cascade');
            $table->primary(['room_id', 'software_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('room_software');
    }
}
