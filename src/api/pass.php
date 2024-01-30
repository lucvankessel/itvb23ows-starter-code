<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/src/game/pass.php';

use game\pass;
use db\connection;

$db = connection\Database::getInstance();
if (pass\passMove($db)) {
    header('Location: /');
    exit(0);
} else {
    $_SESSION['error'] = "Could not pass move";
    header("Location: /");
    exit(0);
}
