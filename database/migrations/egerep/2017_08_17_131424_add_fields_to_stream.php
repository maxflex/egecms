<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToStream extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('egerep')->table('stream', function (Blueprint $table) {
            $table->boolean('gender')->nullable();
            $table->integer('age_from')->unsigned()->nullable();
            $table->integer('age_to')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stream', function (Blueprint $table) {
            //
        });
    }
}
