<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vbaby_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_category_id')->unsigned()->nullable()->default(null);
            $table->string('title', 255);
            $table->text('description');
            $table->text('content');
            $table->integer('ordering')->unsigned()->default(0);
            $table->integer('created_by')->unsigned()->nullable()->default(null);
            $table->integer('updated_by')->unsigned()->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('content_category_id')->references('id')->on('vbaby_content_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vbaby_contents');
    }
}
