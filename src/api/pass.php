<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/src/game/pass.php';

$db = database::getInstance()->get_connection();
if (pass_move($db)) {
    header('Location: /');
    exit(0);
} else {
    $_SESSION['error'] = "Could not pass move";
    header("Location: /");
    exit(0);
}
