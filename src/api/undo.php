<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/src/game/undo.php';

use db\connection;
use game\undo;

if (!isset($_SESSION)) {
    session_start();
}

$database = connection\Database::getInstance();

if (undo\undoMove($database)) {
    header('Location: /');
    exit(0);
} else {
    $_SESSION['error'] = "Could not undo move";
    header("Location: /");
    exit(0);
}
