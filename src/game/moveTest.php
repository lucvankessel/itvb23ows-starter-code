<?php

require_once dirname(__FILE__).'/../db/database.php';
require_once dirname(__FILE__).'/restart.php';
require_once dirname(__FILE__).'/move.php';
require_once dirname(__FILE__).'/play.php';

use PHPUnit\Framework\TestCase;
use db\connection\DB;
use db\connection;
use game\restart;
use game\move;
use game\play;

class MoveTest extends TestCase
{
    public function testMovePossibleOnOldTile()
    {
        // na verplaatsing geen move mogelijk op de oude tegel
        if (!isset($_SESSION)) {
            session_start();
        }

        $double = Mockery::mock(DB::class);
        $double->allows()->startGame()->andReturns(true);
        $double->allows()->getLastInsert()->andReturns(1);

        restart\restartGame($double);
        connection\setState('a:3:{i:0;a:2:{i:0;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:1;s:1:"A";i:3;s:1:"G";i:3;}i:1;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:1;s:1:"A";i:3;s:1:"G";i:3;}}i:1;a:8:{s:3:"0,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"Q";}}s:3:"0,1";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"Q";}}s:4:"-1,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,2";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:4:"0,-1";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,3";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:5:"-1,-1";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"S";}}s:3:"0,4";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"S";}}}i:2;i:0;}');

        $double->allows()->insertMove([
            1,
            'move',
            '0,-1',
            '0,-2',
            0,
            'a:3:{i:0;a:2:{i:0;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:1;s:1:"A";i:3;s:1:"G";i:3;}i:1;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:1;s:1:"A";i:3;s:1:"G";i:3;}}i:1;a:8:{s:3:"0,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"Q";}}s:3:"0,1";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"Q";}}s:4:"-1,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,2";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:4:"0,-1";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,3";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:5:"-1,-1";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"S";}}s:3:"0,4";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"S";}}}i:2;i:1;}'
        ])->andReturns(['id' => 1]);
        $double->allows()->getLastInsert()->andReturns(1);

        $double->allows()->insertMove([
            1,
            'play',
            'S',
            '0,5',
            1,
            'a:3:{i:0;a:2:{i:0;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:1;s:1:"A";i:3;s:1:"G";i:3;}i:1;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:0;s:1:"A";i:3;s:1:"G";i:3;}}i:1;a:9:{s:3:"0,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"Q";}}s:3:"0,1";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"Q";}}s:4:"-1,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,2";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:3:"0,3";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:5:"-1,-1";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"S";}}s:3:"0,4";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"S";}}s:4:"0,-2";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,5";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"S";}}}i:2;i:0;}'
        ])->andReturns(['id' => 2]);

        $double->allows()->insertMove([
            1,
            'move',
            '0,0',
            '0,-1',
            1,
            'a:3:{i:0;a:2:{i:0;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:1;s:1:"A";i:3;s:1:"G";i:3;}i:1;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:0;s:1:"A";i:3;s:1:"G";i:3;}}i:1;a:9:{s:3:"0,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"Q";}}s:3:"0,1";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"Q";}}s:4:"-1,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,2";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:3:"0,3";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:5:"-1,-1";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"S";}}s:3:"0,4";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"S";}}s:4:"0,-2";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,5";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"S";}}}i:2;i:1;}'
        ])->andReturns(['id' => 3]);

        $one = move\movePiece($double, '0,-1', '0,-2');
        $this->assertTrue($one);

        $two = play\playMove($double, 'S', '0,5');
        $this->assertTrue($two);

        $three = move\movePiece($double, '0,0', '0,-1');
        $this->assertTrue($three);
    }

}
