<?php

namespace Tests\Feature;

use App\User;
use App\Game;
use App\GameRules\RockPaperScissors;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RockPaperScissorsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRockPaperScissors()
    {
      // data setup:

      $barlet = factory(User::class)->create([
        'name' => 'Bartlet',
        'email' => 'bartlet@withfatpanda.com',
      ]);

      $coal = factory(User::class)->create([
        'name' => 'Coal',
        'email' => 'coal@withfatpanda.com',
      ]);

      $game = new Game;
      $game->createdBy()->associate($coal);
      $game->type = 'App\Rules\RockPaperScissors';
      $game->save();

      $game->players()->createMany([
        [
          'user_id' => $barlet->id,
        ],
        [ 
          'user_id' => $coal->id,
        ]
      ]);

      // playing the game: applying the rules to the game:

      $rules = new RockPaperScissors;
 
      $rules->setUp($game);

      $this->assertEquals(1, Game::findOrFail($game->id)->round);

      $this->assertEquals(
        Game::findOrFail($game->id)->players()->first()->id, 
        $rules->getNextPlayer($game)->id
      );
    
      $rules->doTurn($game, $rules->getNextPlayer($game), ['choice' => 'rock']);

      // try to make Player 1 take a turn again; should result in Exception
      
      // make Player 2 take turn; should result in Round 2
      
      // test public Game state to see which Player won round #1
      
      // repeat basic test paradigm for 3 rounds
      
      // game should end after Round 3 and/or two consecutive wins by one player

    }
}
