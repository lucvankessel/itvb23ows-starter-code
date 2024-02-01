<?php

require_once dirname(__FILE__).'/../db/database.php';
require_once dirname(__FILE__).'/restart.php';
require_once dirname(__FILE__).'/play.php';

use PHPUnit\Framework\TestCase;
use db\connection\DB;
use db\connection;
use game\restart;
use game\play;

class PlayTest extends TestCase
{

    public function testFourthMoveNotPossible()
    {
        // na 4e zet wit zonder koningin geen moves meer mogelijk.
        if (!isset($_SESSION)) {
            session_start();
        }

        $double = Mockery::mock(DB::class);
        $double->allows()->startGame()->andReturns(true);
        $double->allows()->getLastInsert()->andReturns(1);

        restart\restartGame($double);
        connection\setState('a:3:{i:0;a:2:{i:0;a:5:{s:1:"Q";i:1;s:1:"B";i:0;s:1:"S";i:1;s:1:"A";i:3;s:1:"G";i:3;}i:1;a:5:{s:1:"Q";i:1;s:1:"B";i:0;s:1:"S";i:1;s:1:"A";i:3;s:1:"G";i:3;}}i:1;a:6:{s:3:"0,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,1";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:4:"0,-1";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,2";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:4:"0,-2";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"S";}}s:3:"0,3";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"S";}}}i:2;i:0;}');

        $falseReturn = play\playMove($double, "S", "0,-3");
        $this->assertFalse($falseReturn);

        $double->allows()->insertMove(
            [
                1,
                'play',
                'Q',
                '0,-3',
                0,
                'a:3:{i:0;a:2:{i:0;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:1;s:1:"A";i:3;s:1:"G";i:3;}i:1;a:5:{s:1:"Q";i:1;s:1:"B";i:0;s:1:"S";i:1;s:1:"A";i:3;s:1:"G";i:3;}}i:1;a:7:{s:3:"0,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,1";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:4:"0,-1";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,2";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:4:"0,-2";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"S";}}s:3:"0,3";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"S";}}s:4:"0,-3";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"Q";}}}i:2;i:1;}'
            ])->andReturns([]);
        $double->allows()->getLastInsert()->andReturns(1);

        $trueReturn = play\playMove($double, "Q", "0,-3");
        $this->assertTrue($trueReturn);
    }
}
