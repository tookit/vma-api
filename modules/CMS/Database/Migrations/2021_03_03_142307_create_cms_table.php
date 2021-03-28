<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_post', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id',false, true)->default(0)->comment('post category');
            $table->string('slug')->unique();
            $table->string('name')->comment('post title');
            $table->mediumText('description')->nullable()->comment('post short description');
            $table->text('body')->nullable();
            $table->tinyInteger('status')->default(0)->comment('post status');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('cms_category', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name')->comment('category title');
            $table->mediumText('description')->nullable()->comment('category short description');
            $table->text('body')->nullable();
            $table->unsignedInteger('sort_number');
            $table->tinyInteger('status')->default(0)->comment('category status');
            $table->softDeletes();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_post');
        Schema::dropIfExists('cms_category');
    }
}