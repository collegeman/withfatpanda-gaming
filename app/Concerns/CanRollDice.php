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

  function rollDice(String $dice = '2d6')
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

    // hint #4: to see what value is stored in a variable,
    // use print_r(), e.g., print_r($dice) to print the
    // contents to the screen; another handy trick is to
    // follow a call to print_r() by a call to exit(), thus
    // terminating your script and making it easier to read
    // the output that you were investigating, like so:
    // print_r($someVariable); exit;.
  
    // process the input, determine the dice rolls
    $result = [
      'total' => 0,
      'dice' => []
    ];

    $rolls = explode(' ', $dice);
   
    // roll the dice, capture each individual result
    foreach($rolls as $roll) {
      list($dice, $sides) = explode('d', $roll);
      $result['dice'][$roll] = [];
      for($i=0; $i<$dice; $i++) {
        $value = rand(1, $sides);
        $result['dice'][$roll][] = $value;
        $result['total'] += $value;
      }
    }

    print_r($result);

    // put total and all individual dice into $result

    return $result;
  }

}