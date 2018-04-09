<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePagesArticleAndCreatePageArticlesPreferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages_article', function(Blueprint $table) {
            $table->dropColumn('is_ordered_asc');
        });

        Schema::create('pages_article_preferences', function (Blueprint $table) {
            $table->unsignedInteger('page_id')->nullable();
            $table->boolean('is_ordered_asc')->default(true);
            $table->foreign('page_id')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
