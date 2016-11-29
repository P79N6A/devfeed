<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixSpiderBugs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotas', function (Blueprint $table) {
            $table->string('url', 255)->change();
            $table->longText('content')->change();
        });

        Schema::table('articles', function(Blueprint $table) {
            $table->string('author_url', 255)->nullable()->change();
            $table->longText('content')->change();
        });

        Schema::table('sites', function(Blueprint $table) {
            $table->dropColumn('last_check');
        });

        Schema::table('sites', function(Blueprint $table) {
            $table->string('name', 100)->change();
            $table->string('url', 255)->change();
            $table->string('list_url', 255)->change();
            $table->string('sel_link', 200)->change();
            $table->string('sel_title',200)->change();
            $table->string('sel_content',200)->change();
            $table->string('sel_tag',200)->change();
            $table->string('sel_author_link',200)->change();
            $table->string('sel_author_name',200)->change();
            $table->dateTime('last_check')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotas', function (Blueprint $table) {
            //
        });
    }
}
