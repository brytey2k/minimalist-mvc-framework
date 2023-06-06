<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableNameTablemSPrSVjZ extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema()->create('table_name', function (Blueprint $table) {
            $table->id('comment_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('url')->nullable();
            $table->text('content');
            $table->foreignId('author_id')->references('user_id')->on('users')->cascadeOnUpdate()->noActionOnDelete();
            $table->foreignId('post_id')->references('post_id')->on('posts')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_name');
    }
}