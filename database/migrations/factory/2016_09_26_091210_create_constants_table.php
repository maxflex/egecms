<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConstantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('factory')->create('constants', function (Blueprint $table) {
            $table->string('name')->primary();
            $table->string('value');
        });
        \DB::connection('factory')->table('constants')->insert([
            'name' => 'TRANSPORT_DISTANCE',
            'value' => 1500
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('factory')->dropIfExists('constans');
    }
}
