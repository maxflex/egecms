<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('factory')->create('sort', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
        });
        \DB::connection('factory')->table('sort')->insert([
            ['title' => 'по цене – сначала дороже'],
            ['title' => 'по цене – сначала дешевле'],
            ['title' => 'по популярности'],
            ['title' => 'по близости к метро'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sort');
    }
}
