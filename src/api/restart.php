<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/src/game/restart.php';

use db\connection;
use game\restart;

if (!isset($_SESSION)) {
    session_start();
}

$db = connection\Database::getInstance();

if (restart\restartGame($db)) {
    header('Location: /');
    exit(0);
} else {
    $_SESSION['error'] = "Could not restart game";
    header("Location: /");
    exit(0);
}
