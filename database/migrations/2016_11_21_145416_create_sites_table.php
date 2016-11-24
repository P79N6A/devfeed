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
            $table->string('name', 50);
            $table->string('url', 100);
            $table->string('list_url', 100);
            $table->string('sel_link', 20);
            $table->string('sel_title',20);
            $table->string('sel_content',20);
            $table->string('sel_tag',20);
            $table->string('sel_author_link',20);
            $table->string('sel_author_name',20);
            $table->boolean('published')->default(false);
            $table->integer('last_check', false, true);
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
