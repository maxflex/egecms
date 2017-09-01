<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrioritToFactory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('factory')->create('priorities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->smallInteger('position')->unsigned();
        });

        \DB::connection('factory')->table('priorities')->insert([
            ['title' => 'самых популярных по Москве', 'position' => 3],
            ['title' => 'у репетитора в районе', 'position' => 1],
            ['title' => 'выезжающих в район', 'position' => 2],
            ['title' => 'дешевле', 'position' => 4],
            ['title' => 'дороже', 'position' => 5],
            ['title' => 'с максимальным рейтингом', 'position' => 6],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('factory')->dropTable('priorities');
    }
}
