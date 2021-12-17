<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("category");
            $table->integer("min_age")->nullable();
            $table->integer("max_age")->nullable();
            $table->string("education");
            $table->string("gender")->nullable();
            $table->float("salary")->nullable();
            $table->string("location")->nullable();
            $table->dateTime("expired_at");
            $table->dateTime("lived_at");
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
        Schema::dropIfExists('positions');
    }
}
