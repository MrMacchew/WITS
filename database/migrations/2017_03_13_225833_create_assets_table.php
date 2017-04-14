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
            $table->integer('replacement_id');
            $table->string('description');
            $table->string('weber_inventory_tag');
            $table->string('acquisition_date');
            // $table->string('mac_address_wired'); // Moved to Asset Property Tables
            // $table->string('mac_address_wireless'); // Moved to Asset Property Tables
            // $table->string('operating_system'); // Moved to Asset Property Tables
            $table->decimal('cost', 7, 2); 
            // $table->string('software'); // Moved to Asset Property Tables
            // $table->string('vendor');  // Moved to Asset Property Tables
            // $table->string('vendor_serial_number');
            $table->string('serial_number');
            $table->string('po_number');
            $table->integer('category_id');
            $table->boolean('checkoutable');

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
