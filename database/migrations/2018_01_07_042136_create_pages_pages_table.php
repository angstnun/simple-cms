<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_pages', function (Blueprint $table) {
            $table->unsignedInteger('page_id_0')->nullable();
            $table->unsignedInteger('page_id_1')->nullable();
            $table->foreign('page_id_0')->references('id')->on('pages');
            $table->foreign('page_id_1')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_pages');
    }
}
