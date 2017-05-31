<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingRoomPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_room', function (Blueprint $table) {
            $table->integer('building_id')->unsigned()->index();
            $table->foreign('building_id')->references('id')->on('building')->onDelete('cascade');
            $table->integer('room_id')->unsigned()->index();
            $table->foreign('room_id')->references('id')->on('room')->onDelete('cascade');
            $table->primary(['building_id', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('building_room');
    }
}
