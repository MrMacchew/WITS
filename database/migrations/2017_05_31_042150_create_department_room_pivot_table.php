<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentRoomPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_room', function (Blueprint $table) {
            $table->integer('department_id')->unsigned()->index();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->integer('room_id')->unsigned()->index();
            $table->foreign('room_id')->references('id')->on('room')->onDelete('cascade');
            $table->primary(['department_id', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('department_room');
    }
}
