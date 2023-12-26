<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';

$_SESSION['board'] = [];
$_SESSION['hand'] = [0 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3], 1 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]];
$_SESSION['player'] = 0;
$_SESSION['last_move'] = 0;

$db = database::getInstance()->get_connection();
$stmt = $db->prepare('INSERT INTO games VALUES ()')->execute();
$result = $db->lastInsertId();
$_SESSION['game_id'] = $result;

header('Location: /');
exit(0);
?>