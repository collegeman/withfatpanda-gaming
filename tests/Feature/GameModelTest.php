<?php

namespace Tests\Feature;

use App\User;
use App\Game;
use App\Player;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the game model.
     *
     * @return void
     */
    public function testGameModel()
    {
        $aaron = factory(User::class)->create([
          'name' => 'Aaron Collegeman',
          'email' => 'aaron@withfatpanda.com',
        ]);

        $caius = factory(User::class)->create([
          'name' => 'Caius Ruscella',
          'email' => 'caius@withfatpanda.com',
        ]);

        // create a game
        $game = new Game;
        $game->createdBy()->associate($aaron);
        $game->type = 'MasterSuiac\TicTacToe\Rules';
        $game->save();

        $this->assertEquals(1, Game::count());

        // add players
        $game->players()->createMany([
          [
            'user_id' => $aaron->id,
          ],
          [ 
            'user_id' => $caius->id,
          ]
        ]);

        $game->players[1]->money = 30000;
        $game->players[1]->save();

        $this->assertEquals(30000, Game::first()->players[1]->money);

        $this->assertEquals(2, Game::first()->players()->count());

        // add arbitrary meta data
        $game->board = [ 2 => 'X' ];
        // save, then reload, then test:
        $game->save();
        $game = Game::find($game->id);
        $this->assertEquals($game->board[2], 'X');

        $game->board = [ 2 => 'O' ];
        $game->save();
        $game = Game::find($game->id);
        $this->assertEquals($game->board[2], 'O'); 

        $game->board = ( $game->board ?: [] ) + [ 3 => 'O' ];
        $game->save();
        $game = Game::find($game->id);
        $this->assertEquals($game->board[2], 'O'); 
        $this->assertEquals($game->board[3], 'O'); 
        


    }
}
