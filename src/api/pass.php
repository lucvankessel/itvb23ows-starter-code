<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/src/game/pass.php';

use game\pass;
use db\connection;

$db = connection\database::getInstance()->get_connection();
if (pass\pass_move($db)) {
    header('Location: /');
    exit(0);
} else {
    $_SESSION['error'] = "Could not pass move";
    header("Location: /");
    exit(0);
}
