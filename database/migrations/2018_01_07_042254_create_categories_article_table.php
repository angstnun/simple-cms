<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_article', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('article_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('article_id')->references('id')->on('article');
            $table->unique(['category_id', 'article_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_article');
    }
}
