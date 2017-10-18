<?php
namespace App\Concerns;

trait CanRollDice {

  /**
   * Roll X Y-sided dice.
   * @param  String $dice An expression of one or more sets of dice to roll,
   * e.g., "2d6" means "Roll 2 6-sided dice" and "2d6 1d12" means "Roll 2
   * 6-sided dice and 1 12-sided die." Return both the total of all dice,
   * as well as the individual values of each die.
   * @return array An array with the following elements, indexed by name:
   *  - "total": The total of all the dice that were roled
   *  - "dice": An array of the sets of dice that were rolled, with their
   *   individual values, as follows: the key of the array should be the 
   *   expression of the dice, e.g., "2d6", and the value should also be an
   *   array, with one element for each die and its value, e.g., 
   *   array('2d6' => array(5, 4), '1d12' => array(7))
   */
  function rollDice($dice = '2d6')
  {
    // hint #1: the function rand($x, $y) returns a random number
    // between $x and $y including the values $x and $y, such that
    // rand(1, 12) will return a number between 1 and 12, including
    // the numbers 1 and 12
    
    // hint #2: the function explode($delimiter, $string) splits 
    // the given $string into an array, separated by $delimiter, 
    // for example, the phrase "2d6" can be exploded into an array
    // like array(2, 6) with the expression explode('d', '2d6')

    // hint #3: remember how to build arrays! like this:
    // array (
    //   'total' => 10,
    //   'dice' => array(
    //     '2d6' => array(4, 5),
    //     '1d12' => array(7)
    //   )
    // )
    
    $result = array();

    // process the input, determine the dice rolls
    
    // roll the dice, capture each individual result
    
    // sum the results to build "total"

    // put total and all individual dice into $result

    return $result;
  }


}