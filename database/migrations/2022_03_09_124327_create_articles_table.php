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
            $table->mediumText('guid');
            $table->string('category')->nullable()->default('uncategorized');
            $table->string('pubdate');
            $table->string('pubdateTimestamp');
            $table->string('staticHash')->default("nostatichash");
            $table->string('dynamicHash')->default("nodynamichash");
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
