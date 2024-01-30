<?php
namespace game\undo;

require_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/src/game/restart.php';

use db\connection;
use game\restart;
use Exception;

if (!isset($_SESSION)) {
    session_start();
}

function undoMove(connection\DB $database)
{
    $result = $database->getMove($_SESSION['last_move']);

    if ($result['previous_id'] == 0) {
        restart\restartGame($database);
        return true;
    }

    $delStmt = $database->getConnection()->prepare("DELETE FROM moves WHERE id=?");
    $delStmt->execute([$result['id']]);

    $result2 = $database->getMove($result['previous_id']);

    $_SESSION['last_move'] = $result2['id'];
    connection\setState($result2['state']);

    return true;
}
