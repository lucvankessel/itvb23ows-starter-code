<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';

function restart_game($database) {
    session_start();

    $_SESSION['board'] = [];
    $_SESSION['hand'] = [0 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3], 1 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]];
    $_SESSION['player'] = 0;
    $_SESSION['last_move'] = 0;

    $stmt = $database->prepare('INSERT INTO games VALUES ()')->execute();
    $result = $database->lastInsertId();
    $_SESSION['game_id'] = $result;

    return true;
}
