<?php
require_once "util.php";
require_once __DIR__ .'/../game_rules/insect.php';

use PHPUnit\Framework\TestCase;

use function util\hasNeighBour;
use function util\isNeighbour;
use function util\len;
use function util\neighboursAreSameColor;
use function util\slide;
use function insects\isWin;

class UtilTest extends TestCase
{

    public function testIsNeighbour()
    {
        $this->assertTrue(isNeighbour('0,0', '0,1'));
        $this->assertTrue(isNeighbour('0,0', '1,0'));
        $this->assertTrue(isNeighbour('0,0', '0,-1'));
        $this->assertTrue(isNeighbour('0,0', '-1,0'));
        $this->assertTrue(isNeighbour('0,0', '-1,1'));
        $this->assertTrue(isNeighbour('0,0', '1,-1'));

        $this->assertFalse(isNeighbour('0,0', '1,1'));
        $this->assertFalse(isNeighbour('0,0', '2,2'));
    }

    public function testHasNeighBour()
    {
        $board = ['0,0' => [], '0,1' => [], '1,0' => []];
        $this->assertTrue(hasNeighBour('0,0', $board));
        $this->assertNull(hasNeighBour('2,2', $board));
    }

    public function testNeighboursAreSameColor()
    {
        $board = [
            '0,0' => [['B', 1]],
            '0,1' => [['B', 2]],
            '1,0' => [['W', 1]]
        ];

        $this->assertTrue(neighboursAreSameColor('B', '-1,0', $board));
        $this->assertFalse(neighboursAreSameColor('B', '1,1', $board));
    }

    public function testLen()
    {
        $this->assertEquals(0, len([]));
        $this->assertEquals(3, len([['B'], ['B'], ['B']]));
    }

    public function testSlide()
    {
        $trueBoard = [
            '0,-1' => [[0, 'B']],
            '0,0' => [[0, 'Q'] ],
            '0,1' => [[1, "B"]]
        ];

        $falseBoard = [
            '0,0' => [[0, 'Q']],
            '0,1' => [[1, 'B']],
            '0,-1' => [[0, 'B']],
            '1,0' => [[1, 'A']],
            '-1,0' => [[0, 'A']],
            '-1,1' => [[1, 'Q']]
        ];

        $this->assertTrue(slide($trueBoard, '0,-1', '-1,0'));
        $this->assertFalse(slide($falseBoard, '0,0', '1,-1'));
    }

    public function testIsWin()
    {
        $winBoard = [
            '0,0' => [[0, 'Q']],
            '1,0' => [[1, 'B']],
            '-1,0' => [[0, 'B']],
            '0,-1' => [[0, 'B']],
            '0,1' => [[1, 'B']],
            '1,1' => [[1, 'Q']],
            '-2,1' => [[0, 'S']],
            '-1,1' => [[1, 'A']],
            '-2,2' => [[0, 'S']],
            '1,-1' => [[0, 'A']]
        ];

        $noWinBoard = [
            '0,0' => [[0, 'Q']],
            '1,0' => [[1, 'B']],
            '-1,0' => [[0, 'B']],
            '0,1' => [[1, 'B']],
            '1,1' => [[1, 'Q']],
            '-2,1' => [[0, 'S']],
            '-1,1' => [[1, 'A']],
            '-2,2' => [[0, 'S']],
            '1,-1' => [[0, 'A']]
        ];

        $drawBoard = [
            '0,0' => [[0, 'Q']],
            '1,0' => [[1, 'B']],
            '-1,0' => [[0, 'B']],
            '0,-1' => [[0, 'B']],
            '0,1' => [[1, 'B']],
            '1,1' => [[1, 'Q']],
            '-2,1' => [[0, 'S']],
            '-1,1' => [[1, 'A']],
            '-2,2' => [[0, 'S']],
            '1,-1' => [[0, 'A']],
            '2,0' => [[1, 'S']],
            '1,2' => [[1, 'S']],
            '-1,2' => [[0, 'A']],
            '2,1' => [[1, 'A']],
            '0,2' => [[0, 'A']]
        ];

        $this->assertEquals(0, isWin($noWinBoard)); // no queen circled.
        $this->assertEquals(2, isWin($winBoard)); // black wins.
        $this->assertEquals(3, isWin($drawBoard)); // draw, both queens circled.
    }

}
