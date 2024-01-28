<?php

use PHPUnit\Framework\TestCase;
use insects\spider;

class SpiderTest extends TestCase
{

    public function testSpiderMoves3Tiles()
    {
        $spider = new spider\Spider();
        $board = [
            "0,0" => [],
            "0,1" => [],
            "0,2" => [],
            "0,3" => [],
            "0,4" => [],
            "0,5" => []
        ];
        // a. Een spin verplaatst zich door precies drie keer te verschuiven.
        $this->assertTrue($spider->validMove($board, "0,0", "1,2"));
        $this->assertFalse($spider->validMove($board, "0,0", "1,3"));
    }

    public function testSpiderSlides()
    {
        $spider = new spider\Spider();

        $boardFalse = [
            "0,0" => [],
            "0,1" => [],
            "0,-1" => [],
            "1,0" => [],
            "-1,0" => [],
            "-1,1" => []
        ];

        $boardTrue = [
            "0,0" => [],
            "0,1" => [],
            "0,-1" => [],
            "-1,0" => [],
            "-1,1" => []
        ];

        // b. Een verschuiving is een zet zoals de bijenkoningin die mag maken.
        $this->assertTrue($spider->validMove($boardTrue, "0,0", "0,2"));
        $this->assertFalse($spider->validMove($boardFalse, "0,0", "0,2"));
    }

    public function testSpiderMoveToOwnPosition()
    {
        $spider = new spider\Spider();

        $board = [
            "0,0" => [],
            "0,1" => [],
            "0,2" => [],
            "0,3" => [],
            "0,4" => [],
            "0,5" => []
        ];

        // c. Een spin mag zich niet verplaatsen naar het veld waar hij al staat.
        $this->assertFalse($spider->validMove($board, "0,0", "0,0"));
    }

    public function testSpiderMoveToEmptyField()
    {
        $spider = new spider\Spider();

        $board = [
            "0,0" => [],
            "0,1" => [],
            "0,2" => [],
            "0,3" => [],
            "0,4" => [],
            "0,5" => []
        ];

        // d. Een spin mag alleen verplaatst worden over en naar lege velden.
        $this->assertFalse($spider->validMove($board, "0,0", "0,3"));
    }
}
