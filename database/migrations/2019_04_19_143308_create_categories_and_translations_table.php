<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesAndTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->index();
            $table->timestamps();
        });

        Schema::table('meals', function(Blueprint $table) {
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });

        Schema::create('category_translations', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('locale_id')->unsigned();

            $table->string('title');

            $table->unique(['category_id', 'locale_id']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::table('meals', function(Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::table('category_translations', function(Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['locale_id']);
            $table->dropColumn('category_id');
            $table->dropColumn('locale_id');
        });
        Schema::dropIfExists('categories');
        Schema::dropIfExists('category_translations');
    }
}
