<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullablesToPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->integer('sort')->nullable()->change();
            $table->integer('place')->nullable()->change();
            $table->integer('seo_desktop')->nullable()->change();
            $table->integer('seo_mobile')->nullable()->change();
            $table->integer('station_id')->nullable()->change();
        });


        \DB::table('pages')->where('sort', 0)->update([
            'sort' => 1
        ]);

        \DB::table('pages')->where('place', 0)->update([
            'place' => null
        ]);

        \DB::table('pages')->where('seo_desktop', 0)->update([
            'seo_desktop' => null
        ]);

        \DB::table('pages')->where('seo_mobile', 0)->update([
            'seo_mobile' => null
        ]);

        \DB::table('pages')->where('station_id', 0)->update([
            'station_id' => null
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            //
        });
    }
}
