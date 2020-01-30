<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apilog.connection'))::create('api_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('method');
            $table->string('url');
            $table->longText('payload');
            $table->longText('response');
            $table->string('duration');
            $table->string('controller');
            $table->string('action');
            $table->string('models');
            $table->string('ip');
            $table->string('real_ip')->nullable();
            $table->string('device')->nullable();
            $table->string('platform')->nullable();
            $table->string('platform_version')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->longText('log');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_logs');
    }
}
