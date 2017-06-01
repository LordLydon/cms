<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class Fkeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function ($table) {
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::table('documents', function ($table) {
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::table('surveys', function ($table) {
            $table->foreign('page_id')->references('id')->on('pages');
        });

        Schema::table('survey_results', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('survey_id')->references('id')->on('surveys');
        });

        Schema::table('survey_options', function ($table) {
            $table->foreign('survey_id')->references('id')->on('surveys');
        });

        Schema::table('pages', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('page_id')->references('id')->on('pages');
        });

        Schema::table('category_page', function ($table) {
            $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::table('categories', function ($table) {
            $table->dropForeign(['category_id']);
        });

        Schema::table('documents', function ($table) {
            $table->dropForeign(['category_id']);
        });

        Schema::table('surveys', function ($table) {
            $table->dropForeign(['page_id']);
        });

        Schema::table('survey_results', function ($table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['survey_id']);
        });

        Schema::table('survey_options', function ($table) {
            $table->dropForeign(['survey_id']);
        });

        Schema::table('pages', function ($table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['page_id']);
        });
/*
        Schema::table('category_page', function ($table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['page_id']);
  +      });*/
    }
}
