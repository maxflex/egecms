<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVariableGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variable_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::table('variables', function (Blueprint $table) {
            $table->integer('group_id')->unsigned()->nullable()->default(null);
            $table->foreign('group_id')->references('id')->on('variable_groups')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('variable_groups');
        Schema::table('variables', function (Blueprint $table) {
            $table->dropColumn('group_id');
        });
    }
}
