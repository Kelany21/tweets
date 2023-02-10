<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sees', function (Blueprint $table) {
            $table->foreignId('user_id')->index()->constrained()->onDelete('CASCADE');
            $table->foreignId('tweet_id')->index()->constrained()->onDelete('CASCADE');
            $table->primary(['user_id', 'tweet_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sees');
    }
}
