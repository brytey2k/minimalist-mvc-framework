<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableNameTableQinIajpQ extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema()->create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('username')->index();
            $table->string('password');
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->timestamp('created_at');
        });

        // let's squeeze a seeder here, we will work on a seeder function soon
        Capsule::table('users')->insert([
            'first_name' => 'Bright',
            'last_name' => 'Nkrumah',
            'username' => 'bright',
            'password' => '$2y$10$Be85/niv.hFw6wklWEj3h.CVxTrMeXyIQqREGD6TFzxiD2Aa8lwHK', // password
            'created_at' => (new DateTime())->format('Y-m-d'),
        ]);
        Capsule::table('users')->insert([
            'first_name' => 'Kojo',
            'last_name' => 'Andoh',
            'username' => 'kojo',
            'password' => '$2y$10$Be85/niv.hFw6wklWEj3h.CVxTrMeXyIQqREGD6TFzxiD2Aa8lwHK', // password
            'created_at' => (new DateTime())->format('Y-m-d'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}