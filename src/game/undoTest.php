<?php
// undo functie werkt niet volledig

require_once dirname(__FILE__).'/../db/database.php';
require_once dirname(__FILE__).'/restart.php';
require_once dirname(__FILE__).'/undo.php';

use PHPUnit\Framework\TestCase;
use db\connection\DB;
use db\connection;
use game\restart;
use game\undo;

class UndoTest extends TestCase
{
    public function testUndoFunction() {
        if (!isset($_SESSION)) {
            session_start();
        }

        $double = Mockery::mock(DB::class);
        $double->allows()->startGame()->andReturns(true);
        $double->allows()->getLastInsert()->andReturns(1);

        restart\restartGame($double);
        connection\setState('a:3:{i:0;a:2:{i:0;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:1;s:1:"A";i:3;s:1:"G";i:3;}i:1;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:0;s:1:"A";i:3;s:1:"G";i:3;}}i:1;a:9:{s:3:"0,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"Q";}}s:3:"0,1";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"Q";}}s:4:"-1,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,2";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:3:"0,3";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:5:"-1,-1";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"S";}}s:3:"0,4";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"S";}}s:4:"0,-2";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,5";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"S";}}}i:2;i:1;}');
        $_SESSION['last_move'] = 5;

        $double->allows()->getMove(5)->andReturns(['id'=> 5, 'previous_id' => 4]);
        $double->allows()->deleteMove(5)->andReturns([]);
        $double->allows()->getMove(4)->andReturns(['id' => 4,'state' => 'a:3:{i:0;a:2:{i:0;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:1;s:1:"A";i:3;s:1:"G";i:3;}i:1;a:5:{s:1:"Q";i:0;s:1:"B";i:0;s:1:"S";i:0;s:1:"A";i:3;s:1:"G";i:3;}}i:1;a:9:{s:3:"0,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"Q";}}s:3:"0,1";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"Q";}}s:4:"-1,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,2";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:3:"0,3";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"B";}}s:5:"-1,-1";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"S";}}s:3:"0,4";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"S";}}s:4:"0,-2";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"B";}}s:3:"0,5";a:1:{i:0;a:2:{i:0;i:1;i:1;s:1:"S";}}}i:2;i:0;}']);

        $result = undo\undoMove($double);
        $this->assertTrue($result);
    }
}