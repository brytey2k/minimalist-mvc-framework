<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableNameTabletYOhwYvX extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema()->create('posts', function (Blueprint $table) {
            $table->id('post_id');
            $table->string('title', 300);
            $table->text('content');
            $table->string('image', 500);
            $table->foreignId('author_id')->references('user_id')->on('users')->cascadeOnUpdate()->noActionOnDelete();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}