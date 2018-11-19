<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('case_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->enum('flag', ['trusted', 'fake'])
                ->default('trusted');
            $table->foreign('case_id')
                ->references('id')
                ->on('cases')
                ->onDelete('cascade');
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
        Schema::dropIfExists('case_results');
    }
}
