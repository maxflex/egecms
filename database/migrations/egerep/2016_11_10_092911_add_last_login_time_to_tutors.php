<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastLoginTimeToTutors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('egerep')->table('tutors', function (Blueprint $table) {
            $table->datetime('last_login_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('egerep')->table('tutors', function (Blueprint $table) {
            $table->dropColumn('last_login_time');
        });
    }
}
