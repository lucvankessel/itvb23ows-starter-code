<?php
namespace game\restart;

require_once dirname(__FILE__).'/../db/database.php';

use db\connection;

if (!isset($_SESSION)) {
    session_start();
}

function restartGame(connection\DB $database)
{
    $_SESSION['board'] = [];
    $_SESSION['hand'] = [0 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3], 1 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]];
    $_SESSION['player'] = 0;
    $_SESSION['last_move'] = 0;

    $startGameResult = $database->startGame();
    $_SESSION['game_id'] = $database->getLastInsert();

    return true;
}
