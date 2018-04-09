<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePagesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages_categories', function (Blueprint $table) {
            $table->unsignedInteger('category_display_type_id')->default('1');
            $table->boolean('is_in_lnavbar')->default(false);
            $table->boolean('is_in_rnavbar')->default(false);
            $table->boolean('is_in_body')->default(true);
            $table->boolean('is_ordered_asc')->default(true);
            $table->foreign('category_display_type_id')->references('id')->on('category_display_type');
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
