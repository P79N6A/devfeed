<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('url', 255);
            $table->string('list_url', 255);
            $table->string('sel_link', 200);
            $table->string('sel_title', 200);
            $table->string('sel_content', 200);
            $table->string('sel_tag', 200);
            $table->string('sel_author_link', 200);
            $table->string('sel_author_name', 200);
            $table->dateTime('last_check')->nullable();
            $table->boolean('published')->default(false);
            $table->unsignedInteger('team_id')->nullable();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sites');
    }
}
