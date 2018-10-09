<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('twitter_access_token_secret', 500)->nullable()->after('address');
            $table->string('twitter_access_token', 500)->nullable()->after('address');
            $table->string('twitter_consumer_secret', 500)->nullable()->after('address');
            $table->string('twitter_consumer_key', 500)->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['twitter_consumer_key', 'twitter_consumer_secret', 'twitter_access_token', 'twitter_access_token_secret']);
        });
    }
}
