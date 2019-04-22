<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsAndTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });

        Schema::create('meal_translations', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('meal_id')->unsigned();
            $table->bigInteger('locale_id')->unsigned();

            $table->string('title');

            $table->unique(['meal_id', 'locale_id']);
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
            $table->foreign('locale_id')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meal_translations', function(Blueprint $table) {
            $table->dropForeign(['meal_id']);
            $table->dropForeign(['locale_id']);
            $table->dropColumn('meal_id');
            $table->dropColumn('locale_id');
        });
        Schema::dropIfExists('meals');
        Schema::dropIfExists('meal_translations');
    }
}
