<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vbaby_content_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('parent_id')->unsigned()->nullable()->default(null);
            $table->integer('ordering')->unsigned()->default(0);
            $table->integer('created_by')->unsigned()->nullable()->default(null);
            $table->integer('updated_by')->unsigned()->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('vbaby_content_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vbaby_content_categories');
    }
}
