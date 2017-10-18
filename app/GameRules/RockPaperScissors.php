<?php
namespace App\GameRules;

use App\Game;
use App\Player;

use App\Contracts\GameRules;

class RockPaperScissors implements GameRules {

  function getMinPlayers(Game $game)
  {
    return 2;
  }

  function getMaxPlayers(Game $game)
  {
    return 2;
  }

  function getMaxSpectators(Game $game)
  {
    return 10;
  }

  function getMaxRounds()
  {
    return 3;
  }

  function setUp(Game $game)
  {
    if ($game->players()->count() < $this->getMinPlayers($game)) {
      throw new \Exception("Game does not have enough players yet.");
    }

    $game->round = 1;
    $game->save();

    $this->setNextPlayer($game, $game->players()->first());
  }

  function setNextPlayer(Game $game, Player $nextPlayer)
  {
    $game->nextPlayer()->associate($nextPlayer);
    $game->save();
  }

  function getNextPlayer(Game $game)
  {
    return $game->nextPlayer;
  }

  function doTurn(Game $game, Player $player, array $input)
  {
    if ($player->id !== $this->getNextPlayer($game)->id) {
      throw new \Exception("You are not allowed to take your turn yet.");
    }

    if (empty($input['choice'])) {
      throw new \Exception("You didn't make a choice about what to play.");
    }

    $validPlays = [ 'rock', 'paper', 'scissors' ];

    if (!in_array($input['choice'], $validPlays)) {
      throw new \Exception("Your play choice must be one of: " . implode(', ', $validPlays));
    }

    $player->choice = $input['choice'];
    $player->save();
  }

  function getPublicGameState(Game $game) 
  {}

  function getSecretGameState(Game $game) 
  {}

  function getAllPublicPlayerState(Game $game)
  {}

  function getPublicPlayerState(Game $game, Player $player) 
  {}

  function getWinningPlayers(Game $game)
  {}

  function isPlayerOut(Game $game, Player $player)
  {}

  function getSecretPlayerState(Player $player)
  {}

  function isGameOver(Game $game)
  {}

  function getWinningPlayer(Game $game)
  {}

  function leave(Game $game, Player $player)
  {}
  
  function tearDown(Game $game)
  {}

}