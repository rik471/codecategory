<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;


class CreateCodeCategoriesTable extends Migration
{
    protected $table = 'codepress_categories';

    public function up()
    {
        Schema::create('codepress_categories', function (Blueprint $table){
           $table->increments('id');
           $table->integer('parent_id')->nullable(true)->unsigned()->default(0);
           $table->foreign('parent_id')->references('id')->on('codepress_categories');
           $table->string('name');
           $table->string('slug');
           $table->boolean('active')->default(false);
           $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('codepress_categories');
    }
}