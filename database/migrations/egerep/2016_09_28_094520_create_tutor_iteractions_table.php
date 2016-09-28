<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorIteractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('egerep')->dropIfExists('tutor_iteractions');
        Schema::connection('egerep')->create('tutor_iteractions', function (Blueprint $table) {
            $table->integer('tutor_id')->unsigned();
            $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');
            $table->integer('gmap')->unsigned();
            $table->integer('svg_map')->unsigned();
            $table->integer('reviews')->unsigned();
            $table->integer('reviews_more')->unsigned();
            $table->integer('request_form')->unsigned();
            $table->integer('request')->unsigned();
            $table->integer('views')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutor_iteractions');
    }
}
