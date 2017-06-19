<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TeamRelatedUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sites', function(Blueprint $table) {
            $table->unsignedInteger('team_id')->nullable();
        });

        Schema::table('quotas', function(Blueprint $table) {
            $table->unsignedInteger('team_id')->nullable();
        });

        Schema::table('articles', function (Blueprint $table){
            $table->unsignedInteger('team_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sites', function(Blueprint $table) {
            $table->dropColumn('team_id');
        });
        Schema::table('quotas', function (Blueprint $table) {
            $table->dropColumn('team_id');
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('team_id');
        });
    }
}