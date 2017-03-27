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
            $table->integer('room_id');
            $table->string('name');
            $table->string('manufacturer');
            $table->string('model');
            $table->string('description');
            $table->string('weber_inventory_tag');
            $table->string('acquisition_date');
            $table->string('mac_address_wired'); // ?
            $table->string('mac_address_wireless'); // ?
            $table->string('operating_system'); // ?
            $table->string('expensive');
            $table->string('software'); // ?
            $table->string('vendor');
            $table->string('vendor_serial_number');
            $table->string('serial_number');
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
        Schema::dropIfExists('assets');

    }
}
