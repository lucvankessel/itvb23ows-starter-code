<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
$db = database::getInstance()->get_connection();
$stmt = $db->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "pass", null, null, ?, ?)');
$stmt->execute([$_SESSION['game_id'], $_SESSION['last_move'], get_state()]);
$_SESSION['last_move'] = $db->lastInsertId();
$_SESSION['player'] = 1 - $_SESSION['player'];

header('Location: /');
exit();
?>