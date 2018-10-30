<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('url');
            $table->mediumText('keywords');
            $table->string('tweet_id');
            $table->string('tweet_author')->nullable();
            $table->string('tweet_image', 500)->nullable();
            $table->string('location')->nullable();
            $table->string('latitude', 500)->nullable();
            $table->string('longitude', 500)->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->enum('flag', ['in_analysis', 'trusted', 'fake'])
                ->default('in_analysis');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
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
        Schema::dropIfExists('cases');
    }
}
