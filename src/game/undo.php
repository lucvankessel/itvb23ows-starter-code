<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';

$db = database::getInstance()->get_connection();
$stmt = $db->prepare('SELECT * FROM moves WHERE id = ?');
$stmt->execute([$_SESSION['last_move']]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['last_move'] = $result[5];
set_state($result[6]);

// because we undo a move we also have to revert to the other player.
$_SESSION['player'] = ($_SESSION['player'] == 0 ? 0 : 1);

header('Location: /');
exit();
?>
