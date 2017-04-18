<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_id')->unsigned();
            $table->string('name');
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->integer('replacement_id')->unsigned()->nullable();
            $table->string('description')->nullable();
            $table->decimal('cost', 7, 2)->nullable();
            $table->string('weber_inventory_tag')->unique()->nullable();
            $table->string('acquisition_date')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('po_number')->nullable();
            $table->boolean('checkoutable')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('room');
            $table->foreign('replacement_id')->references('id')->on('assets');
            $table->foreign('category_id')->references('id')->on('category');

        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');

    }
}
