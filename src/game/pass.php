<?php

session_start();

$db = include __DIR__.'/../db/database.php';
$stmt = $db->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "pass", null, null, ?, ?)');
$stmt->execute(['iis', $_SESSION['game_id'], $_SESSION['last_move'], get_state()]);
$_SESSION['last_move'] = $db->lastInsertId();
$_SESSION['player'] = 1 - $_SESSION['player'];

header('Location: ../../index.php');

?>