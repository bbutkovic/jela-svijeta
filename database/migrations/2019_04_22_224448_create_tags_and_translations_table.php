<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsAndTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->index();
            $table->timestamps();
        });

        Schema::create('meal_tag', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('meal_id')->unsigned();
            $table->bigInteger('tag_id')->unsigned();

            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });

        Schema::create('tag_translations', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tag_id')->unsigned();
            $table->bigInteger('locale_id')->unsigned();

            $table->string('title');

            $table->timestamps();

            $table->unique(['tag_id', 'locale_id']);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::table('meal_tag', function(Blueprint $table) {
            $table->dropForeign(['meal_id']);
            $table->dropForeign(['tag_id']);
            $table->dropColumn('meal_id');
            $table->dropColumn('tag_id');
        });

        Schema::table('tag_translations', function(Blueprint $table) {
            $table->dropForeign(['tag_id']);
            $table->dropForeign(['locale_id']);
            $table->dropColumn('tag_id');
            $table->dropColumn('locale_id');
        });
        Schema::dropIfExists('tags');
        Schema::dropIfExists('meal_tag');
        Schema::dropIfExists('tag_translations');
    }
}
