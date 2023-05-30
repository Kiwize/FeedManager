<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->mediumText('description');
            $table->mediumText('link');
            $table->string('category')->nullable()->default('uncategorized');
            $table->string('pubdate');
            $table->string('static_hash')->default("nostatichash");
            $table->string('dynamic_hash')->default("nodynamichash");
            $table->timestamps();
            $table->timestamp('published_at')->nullable()->useCurrent();
            $table->unsignedInteger('feed_id');
            $table->foreign('feed_id')->references('id')->on('feeds')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
