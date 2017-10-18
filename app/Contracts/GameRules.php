<?php
namespace App\Contracts;

use App\Game;
use App\Player;

/**
 * This interface describes the rules that govern a Game.
 * The Game and its Players are used to store data about
 * the game in progress, while the rules process that data
 * and make decisions about the game: setting it up, 
 * establishing a loop of turns, and determining when the
 * game has ended and who its winners are.
 */
interface GameRules {

  /**
   * What is the minimum number of players this game
   * requires before it can be played?
   * @param  Game   $game The game to test
   * @return int The minimum number of players
   */
  function getMinPlayers(Game $game);

  /**
   * What is the maximum number of players who can
   * play this game at a time?
   * @param  Game   $game The game to test
   * @return int The maximum number of players
   */
  function getMaxPlayers(Game $game);

  /**
   * What is the maximum number of people who are
   * allowed to spectate on this game?
   * @param  Game   $game The game to test
   * @return int The maximum number
   */
  function getMaxSpectators(Game $game);

  /**
   * Setup the given Game, establishing all of the baseline
   * state for the Game and its Players; this is
   * analogous to shuffling the deck in a card game,
   * or handing out money and tokens at the beginning of
   * a board game, and it should also include deciding
   * which player should go first.
   * @param Game $game The game to test
   */
  function setUp(Game $game);

  /**
   * Process a Game's turn by one of its Players,
   * altering Game and Player state, and ultimately
   * testing whether or not the game has been concluded
   * by the Player's input. This method should also enforce
   * who is allowed to take this turn, and if the game is
   * to continue after this turn, this method should establish
   * who is to play next.
   * @param  Game   $game   The game being played
   * @param  Player $player The player trying to take the turn
   * @param  array  $input  An array of input from the player
   * @return null
   */
  function doTurn(Game $game, Player $player, array $input);

  /**
   * Get all data about the Game that should be freely
   * known to all Players, e.g., token positions on a game board,
   * current scores, etc.
   * @param  Game   $game The game from which to extract public data
   * @return array The public data
   */
  function getPublicGameState(Game $game);

  /**
   * Get all data about the Game that should not be known
   * to any of the Players, e.g., the order of cards in a deck,
   * the position of monsters on the game board, etc.
   * @param  Game   $game The game from which to extract secret data
   * @return array The secret data
   */
  function getSecretGameState(Game $game);

  /**
   * Get all data about all Players that should be freely
   * known to all of them.
   * @param  Game   $game The game from which to extract the public player data
   * @return array The public data
   */
  function getAllPublicPlayerState(Game $game);

  /**
   * Get all data about a Player that should be freely
   * known to all Players.
   * @param  Game   $game The game from which to extract the public player data
   * @param  Player $player The player from which to extract public data
   * @return array The public data
   */
  function getPublicPlayerState(Game $game, Player $player);

  /**
   * Get all data about a Player that should not be known
   * to any other Player.
   * @param  Game   $game The game from which to extract the secret player data
   * @param  Player $player The player from which to extract secret data
   * @return array The secret data
   */
  function getSecretPlayerState(Player $player);

  /**
   * This method tests Game and Player state to determine whether
   * or not a player has been eliminated from play.
   * @param  Game    $game   The game to test
   * @param  Player  $player The player to test
   * @return boolean Returns true if the player has been eliminated; otherwise, return false
   */
  function isPlayerOut(Game $game, Player $player);

  /**
   * This method tests Game and Player state to determine whether
   * or not a game has concluded.
   * @param  Game    $game The game to test
   * @return boolean Returns true if the game has concluded; otherwise, returns false
   */
  function isGameOver(Game $game);

  /**
   * Establish as a matter of record and control which Player should
   * next be allowed to invoke Game::doTurn.
   * @param Game   $game The game to update
   * @param Player $nextPlayer The Player to designate as next player
   */
  function setNextPlayer(Game $game, Player $nextPlayer);
  
  /**
   * Retrieve a reference to the Player who should next be allowed
   * to invoke Game::doTurn
   * @param  Game   $game The game to test
   * @return Player If known, the player to go next; otherwise, null
   */
  function getNextPlayer(Game $game);

  /**
   * Get a list of the Players who have won this game
   * @param  Game   $game The game to test
   * @return Collection The list of players
   */
  function getWinningPlayers(Game $game);

  /**
   * Request that a Player be allowed to leave a game, effectively
   * forfeiting to any/all other players. Games may be programmed
   * such that fofeiture is not allowed.
   * @param  Game $game The game to leave
   * @param  Player $player The Player who wants to leave the Game
   * @return void
   * @throws Exception If Player is unable to leave the game
   * @throws Exception If Player has already left the game
   */
  function leave(Game $game, Player $player);
  
  /**
   * This method cleans up after a game, ending it if not already ended.
   * @param  Game   $game The Game which has ended
   * @return void
   * @throws Exception If there is a circumstance which would prevent the game from being cleaned up
   */
  function tearDown(Game $game);

}