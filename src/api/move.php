<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

include_once dirname(__FILE__) .'/../db/database.php';
include_once dirname(__FILE__) .'/../game/move.php';

$from = $_POST['from'];
$to = $_POST['to'];
$db = database::getInstance()->get_connection();

// errors are set in the function right now, maybe move these to exceptions.
move_piece($db, $from, $to);

header('Location: /');
exit();