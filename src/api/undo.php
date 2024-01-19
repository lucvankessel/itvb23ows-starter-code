<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/game/undo.php';

$db = database::getInstance()->get_connection();

if (undo_move($db)) {
    header('Location: /');
    exit(0);
} else {
    $_SESSION['error'] = "Could not undo move";
    header("Location: /");
    exit(0);
}