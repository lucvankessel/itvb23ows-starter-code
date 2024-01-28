<?php
require_once dirname(__FILE__) .'/../db/database.php';
require_once dirname(__FILE__) .'/../game/move.php';

use db\connection;
use game\move;

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$from = $_POST['from'];
$to = $_POST['to'];
$db = connection\database::getInstance()->get_connection();

// errors are set in the function right now, maybe move these to exceptions.
move\move_piece($db, $from, $to);

header('Location: /');
exit();