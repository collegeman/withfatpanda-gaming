<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(64);

        Schema::create('players', function($table) {
            $table->bigIncrements('id');    
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('winner')->default(false);
            $table->text('avatar')->nullable();
            $table->string('screenname', 128)->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games');
            $table->longText('meta')->nullable();
        });

        Schema::create('games', function($table) {
            $table->bigIncrements('id');    
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->string('type', 128);
            $table->enum('status', ['not-started', 'setup', 'started', 'paused', 'finished', 'abandoned'])->default('not-started');
            $table->dateTime('ended_at')->nullable();
            $table->bigInteger('next_player')->unsigned()->nullable();
            $table->foreign('next_player')->references('id')->on('players');
            $table->tinyInteger('max_players')->default(2);
            $table->boolean('private')->default(false);
            $table->longText('meta')->nullable();
        });

        Schema::create('invites', function($table) {
            $table->bigIncrements('id');    
            $table->timestamps();
            $table->softDeletes();
            $table->string('email');
            $table->bigInteger('invitee_id')->unsigned();
            $table->foreign('invitee_id')->references('id')->on('users');
            $table->bigInteger('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_player');
        Schema::dropIfExists('invites');
        Schema::dropIfExists('games');
        Schema::dropIfExists('players');
    }
}
