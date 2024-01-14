<?php

use PHPUnit\Framework\TestCase;
include_once "util.php";
include_once __DIR__ .'/../game_rules/insect.php';

class utilTest extends TestCase {

    public function testIsNeighbour() {
        $this->assertTrue(isNeighbour('0,0', '0,1'));
        $this->assertTrue(isNeighbour('0,0', '1,0'));
        $this->assertTrue(isNeighbour('0,0', '0,-1'));
        $this->assertTrue(isNeighbour('0,0', '-1,0'));
        $this->assertTrue(isNeighbour('0,0', '-1,1'));
        $this->assertTrue(isNeighbour('0,0', '1,-1'));

        $this->assertFalse(isNeighbour('0,0', '1,1'));
        $this->assertFalse(isNeighbour('0,0', '2,2'));
    }

    public function testHasNeighBour() {
        $board = ['0,0' => [], '0,1' => [], '1,0' => []];
        $this->assertTrue(hasNeighBour('0,0', $board));
        $this->assertNull(hasNeighBour('2,2', $board));
    }

    public function testNeighboursAreSameColor() {
        $board = [
            '0,0' => [['B', 1]],
            '0,1' => [['B', 2]],
            '1,0' => [['W', 1]]
        ];

        $this->assertTrue(neighboursAreSameColor('B', '-1,0', $board));
        $this->assertFalse(neighboursAreSameColor('B', '1,1', $board));
    }

    public function testLen() {
        $this->assertEquals(0, len([]));
        $this->assertEquals(3, len([['B'], ['B'], ['B']]));
    }

    public function testSlide() {
        $board = ['0,0' => [], '0,1' => [], '1,0' => []];

        $this->assertTrue(slide($board, '1,0', '1,1'));
        $this->assertFalse(slide($board, '0,0', '2,2'));
    }

    public function testIsWin() {
        $win_board = [
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
        $no_win_board = [            
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
        $draw_board = [
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

        $this->assertEquals(0, is_win($no_win_board)); // no queen circled.
        $this->assertEquals(2, is_win($win_board)); // black wins.
        $this->assertEquals(3, is_win($draw_board)); // draw, both queens circled.
    }

}