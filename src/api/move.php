<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/game/move.php';

$from = $_POST['from'];
$to = $_POST['to'];
$db = database::getInstance()->get_connection();

// errors are set in the function right now, maybe move these to exceptions.
move_piece($db, $from, $to);

header('Location: /');
exit();