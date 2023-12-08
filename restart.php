<?php

session_start();

$_SESSION['board'] = [];
$_SESSION['hand'] = [0 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3], 1 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]];
$_SESSION['player'] = 0;

$db = include_once 'database.php';
$stmt = $db->prepare('INSERT INTO games VALUES ()')->execute();
$result = $db->lastInsertId();
$_SESSION['game_id'] = $result;

header('Location: index.php');

?>