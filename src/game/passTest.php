<?php

require_once("pass.php");

use PHPUnit\Framework\TestCase;
use game\pass;

class PassTest extends TestCase
{

    public function testPlayerCanPass()
    {
        $board = [
            "0,0" => [[0, "Q"]],
            "0,1" => [[1, 'A']],
            "0,-1" => [[1, 'A']],
            "1,0" => [[1, 'A']],
            "-1,0" => [[1, 'A']],
            "-1,1" => [[1, 'A']]
        ];
        $hand = [0 => [], 1=>[]];
        $player = 0;
        
        $this->assertTrue(pass\playerCanPass($board, $hand, $player));
    }

    public function testPlayerCantPassAvailableMove()
    {
        $board = [
            "0,0" => [[0, 'Q']],
            "0,1" => [[1, 'A']],
            "0,-1" => [[1, 'A']],
            "-1,0" => [[1, 'A']],
            "-1,1" => [[1, 'A']]
        ];
        $hand = [
            0 => ["Q" => 0,"B" => 0, "S" => 0, "A" => 0, "G" => 0],
            1 => ["Q" => 0, "B" => 0, "S" => 0, "A" => 0, "G" => 0]
        ];
        $player = 0;

        $this->assertFalse(pass\playerCanPass($board, $hand, $player));
    }

    public function testPlayerCantPassAvailablePlay()
    {
        $board = [
            "0,0" => [[0, 'Q']],
            "0,1" => [[1, 'A']],
            "0,-1" => [[1, 'A']],
            "-1,0" => [[1, 'A']],
            "-1,1" => [[1, 'A']]
        ];
        $hand = [
            0 => ["Q" => 0,"B" => 0, "S" => 1, "A" => 0, "G" => 0],
            1 => ["Q" => 0, "B" => 0, "S" => 0, "A" => 0, "G" => 0]
        ];
        $player = 0;

        $this->assertFalse(pass\playerCanPass($board, $hand, $player));
    }

}
