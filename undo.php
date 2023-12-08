<?php

session_start();

$db = include 'database.php';
$stmt = $db->prepare('SELECT * FROM moves WHERE id = ?');
$stmt->execute([$_SESSION['last_move']]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['last_move'] = $result[5];
set_state($result[6]);
header('Location: index.php');

?>
