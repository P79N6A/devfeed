<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemoteFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remote_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('origin')->default('');
            $table->string('remote')->default('');
            $table->string('local')->default('');
            $table->string('base_url')->default('');
            $table->string('md5', 32)->unique()->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remote_files');
    }
}
