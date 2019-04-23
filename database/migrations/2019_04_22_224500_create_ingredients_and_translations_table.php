<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientsAndTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->index();
            $table->timestamps();
        });

        Schema::create('ingredient_meal', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('meal_id')->unsigned();
            $table->bigInteger('ingredient_id')->unsigned();

            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
        });

        Schema::create('ingredient_translations', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ingredient_id')->unsigned();
            $table->string('locale');

            $table->string('title');

            $table->timestamps();

            $table->unique(['ingredient_id', 'locale']);
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
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
        Schema::table('ingredient_meal', function(Blueprint $table) {
            $table->dropForeign(['meal_id']);
            $table->dropForeign(['ingredient_id']);
            $table->dropColumn('meal_id');
            $table->dropColumn('ingredient_id');
        });

        Schema::table('ingredient_translations', function(Blueprint $table) {
            $table->dropForeign(['ingredient_id']);
            $table->dropForeign(['locale']);
            $table->dropColumn('ingredient_id');
            $table->dropColumn('locale');
        });
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('ingredient_meal');
        Schema::dropIfExists('ingredient_translations');
    }
}
