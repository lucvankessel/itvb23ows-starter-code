<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/src/utils/util.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/src/game_rules/insect.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/src/game/play.php';

use game\play;
use db\connection;

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 


$piece = $_POST['piece'];
$to = $_POST['to'];
$db = connection\database::getInstance()->get_connection();

// right now the play_move sets the errors so we can just redirect to index.php
play\play_move($db, $piece, $to);
Header('Location: /');
exit(0);