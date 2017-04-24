<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mediable_id');
            $table->string('mediable_type');
            $table->string('name');
            // $table->binary('image'); //65 kB (small) laravel doesn't do mediumblobs
            $table->string('mime_type'); //php's mime_content_type('php.gif')
            $table->timestamps();
        });


        DB::statement("ALTER TABLE media ADD image MEDIUMBLOB AFTER name"); // 16MB
        // DB::statement("ALTER TABLE media ADD image LONGBLOB"); // 4G
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
