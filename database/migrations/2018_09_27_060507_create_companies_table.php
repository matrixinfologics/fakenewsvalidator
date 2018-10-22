<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('website')->nullable()->default(null);
            $table->string('phone', 50);
            $table->string('address', 500);
            $table->string('twitter_consumer_key', 500)->nullable();
            $table->string('twitter_consumer_secret', 500)->nullable();
            $table->string('twitter_access_token', 500)->nullable();
            $table->string('twitter_access_token_secret', 500)->nullable();
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
        Schema::dropIfExists('companies');
    }
}
