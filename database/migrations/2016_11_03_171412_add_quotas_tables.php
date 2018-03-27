<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuotasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url', 255);
            $table->longText('content');
            $table->string('title');
            $table->string('tags')->nullable();
            $table->string('site_name');
            $table->string('site_url');
            $table->string('author_name')->nullable();
            $table->string('author_url')->nullable();
            $table->unsignedInteger('team_id')->nullable();
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('quotas');
    }
}
