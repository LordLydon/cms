<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('set null');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::table('surveys', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->foreign('page_id')->references('id')->on('pages')->onDelete('set null');
        });

        Schema::table('survey_results', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->foreign('survey_id')->references('id')->on('surveys');
        });

        Schema::table('survey_options', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::table('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->dropForeign(['category_id']);
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->dropForeign(['category_id']);
        });

        Schema::table('surveys', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->dropForeign(['page_id']);
        });

        Schema::table('survey_results', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->dropForeign(['user_id']);
            $table->dropForeign(['survey_id']);
        });

        Schema::table('survey_options', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->dropForeign(['survey_id']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->dropForeign(['user_id']);
            $table->dropForeign(['page_id']);
        });
    }
}
