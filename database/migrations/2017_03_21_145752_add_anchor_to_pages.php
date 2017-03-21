<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnchorToPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('anchor');
            $table->boolean('anchor_published')->default(false);
            $table->integer('anchor_block_id')->unsigned()->nullable();
            $table->integer('anchor_page_id')->unsigned()->nullable();
            $table->foreign('anchor_page_id')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
        });
    }
}
