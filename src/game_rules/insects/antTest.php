<?php

use PHPUnit\Framework\TestCase;
use insects\ant;

class AntTest extends TestCase
{

    public function testAntMovesWithoutStepLimit()
    {
        $ant = new ant\Ant();

        $board = [
            "0,0" => [],
            "0,1" => [],
            "0,2" => [],
            "0,3" => [],
            "0,4" => [],
            "0,5" => []
        ];
        // a. Een soldatenmier verplaatst zich door een onbeperkt aantal keren te verschuiven
        $this->assertTrue($ant->validMove($board, "0,0", "0,6"));
        $this->assertTrue($ant->validMove($board, "0,0", "1,5"));
    }

    public function testAntSlide()
    {
        $ant = new ant\Ant();

        $board = [
            "0,0" => [],
            "0,1" => [],
            "0,-1" => [],
            "1,0" => [],
            "-1,0" => [],
            "-1,1" => []
        ];

        // b. Een verschuiving is een zet zoals de bijenkoningin die mag maken.
        $this->assertFalse($ant->validMove($board, "0,0", "1,-1"));
        $this->assertTrue($ant->validMove($board, "-1,1", "-2,0"));
    }

    public function testAntCantMoveToSamePlace()
    {
        $ant = new ant\Ant();

        $board = [
            "0,0" => [],
            "0,1" => [],
            "0,2" => [],
            "0,3" => [],
            "0,4" => [],
            "0,5" => []
        ];

        // c. Een soldatenmier mag zich niet verplaatsen naar het veld waar hij al staat.
        $this->assertFalse($ant->validMove($board, "0,0", "0,0"));
    }

    public function testAntMoveOnEmptyFields()
    {
        $ant = new ant\Ant();

        $board = [
            "0,0" => [],
            "0,1" => []
        ];

        // d. Een soldatenmier mag alleen verplaatst worden over en naar lege velden.
        $this->assertFalse($ant->validMove($board, "0,0", "0,1"));
    }
}
