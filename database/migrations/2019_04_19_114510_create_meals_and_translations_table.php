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
            $table->softDeletes();
        });

        Schema::create('meal_translations', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('meal_id')->unsigned();
            $table->string('locale');

            $table->string('title');

            $table->timestamps();

            $table->unique(['meal_id', 'locale']);
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
            $table->foreign('locale')->references('code')->on('languages')->onDelete('cascade');
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
            $table->dropForeign(['locale']);
            $table->dropColumn('meal_id');
            $table->dropColumn('locale');
        });
        Schema::dropIfExists('meals');
        Schema::dropIfExists('meal_translations');
    }
}
