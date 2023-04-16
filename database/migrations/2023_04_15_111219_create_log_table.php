<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('type', 200);
            $table->string('service_name', 255);
            $table->dateTime('date_time');
            $table->string('http_method', 5);
            $table->string('http_path', 50);
            $table->string('http_version', 20);
            $table->integer('http_status_code');
            $table->timestamps();
            $table->index('service_name');
            $table->index('date_time');
            $table->index('http_status_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log');
    }
};

