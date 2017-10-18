<?php
namespace App\GameRules;

use App\Game;
use App\Player;

use App\Contracts\GameRules;

abstract class AbstractGameRules implements GameRules {

  function getMinPlayers(Game $game) {}

  function getMaxPlayers(Game $game) {}

  function getMaxSpectators(Game $game) {}

  function setUp(Game $game) {}

  function doTurn(Game $game, Player $player, array $input) {}

  function getPublicGameState(Game $game) {}

  function getSecretGameState(Game $game) {}

  function getAllPublicPlayerState(Game $game) {}

  function getPublicPlayerState(Game $game, Player $player) {}

  function getSecretPlayerState(Player $player) {}

  function isPlayerOut(Game $game, Player $player) {}

  function isGameOver(Game $game) {}

  function setNextPlayer(Game $game, Player $nextPlayer) {}
  
  function getNextPlayer(Game $game) {}

  function getWinningPlayers(Game $game) {}

  function leave(Game $game, Player $player) {}
  
  function tearDown(Game $game) {}

}