<?php
namespace App\GameRules;

use App\Contracts\GameRules;

use App\Concerns\CanRollDice;

class Opoly extends AbstractGameRules implements GameRules {

  use CanRollDice;

}