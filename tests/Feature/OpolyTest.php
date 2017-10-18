<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\GameRules\Opoly;
use App\GameRules\AbstractGameRules;

class OpolyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $rules = new Opoly;

        $result = $rules->rollDice('2d6');

        $this->assertTrue(is_array($result), "The result of running rollDice should return an array");

        $this->assertTrue(array_key_exists('total', $result), "The array returned by rollDice should contain an element named 'total'");

        $this->assertTrue(array_key_exists('dice', $result), "The array returned by rollDice should contain an element named 'dice'");

        $this->assertTrue(array_key_exists('2d6', $result['dice']), "The dice returned by rollDice should contain a key named '2d6'"); // $result = array('dice' => array('2d6' => ...))

        $this->assertEquals(2, count($result['dice']['2d6']), "There should have been 2 dice rolled.");

        $this->assertTrue($result['total'] >= 2, "The total of the dice must be greater than or equal to 2");

        $this->assertTrue($result['total'] <= 12, "The total of the dice must be less than or equal to 12");

        $this->assertTrue(array_sum($result['dice']['2d6']) >= 2, "The total of the dice must be greater than or equal to 2");

        $this->assertTrue(array_sum($result['dice']['2d6']) <= 12, "The total of the dice must be less than or equal to 12");
    }
}
