<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYandexMetricaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metrica_visits', function (Blueprint $table) {
            $table->increments('id');
            foreach(\App\Service\Metrica::VISITS_FIELDS as $field) {
                $table->text(explode(':', $field)[2]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yandex_metrica');
    }
}
