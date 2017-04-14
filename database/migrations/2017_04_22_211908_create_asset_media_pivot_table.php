<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetMediaPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_media', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('asset_id')->unsigned()->index();
            $table->integer('media_id')->unsigned()->index();
            // $table->primary(['asset_id', 'media_id']);
        });


         Schema::table('asset_media', function (Blueprint $table) {
            $table->foreign('asset_id')->references('id')->on('assets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('media_id')->references('id')->on('media')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['asset_id', 'media_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('asset_media');
    }
}
