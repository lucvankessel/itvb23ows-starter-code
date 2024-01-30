<?php
namespace game\restart;

if (!isset($_SESSION)) {
    session_start();
}

function restartGame($database)
{
    $_SESSION['board'] = [];
    $_SESSION['hand'] = [0 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3], 1 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]];
    $_SESSION['player'] = 0;
    $_SESSION['last_move'] = 0;

    // $database->prepare('INSERT INTO games VALUES ()')->execute();
    $startGameResult = $database->startGame();
    $data = $database->getConnection()->lastInsertId();
    $_SESSION['game_id'] = $data;

    return true;
}
