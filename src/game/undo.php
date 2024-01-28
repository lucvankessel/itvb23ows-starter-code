<?php
namespace game\undo;

require_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/src/game/restart.php';

use db\connection;
use game\restart;

if (!isset($_SESSION)) {
    session_start();
}

function undoMove($database)
{
    $stmt = $database->prepare('SELECT * FROM moves WHERE id = ?');
    $stmt->execute([$_SESSION['last_move']]);
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($result['previous_id'] == 0) {
        restart\restartGame($database);
        return true;
    }

    $delStmt = $database->prepare("DELETE FROM moves WHERE id=?");
    $delStmt->execute([$result['id']]);

    $stmt2 = $database->prepare('SELECT * FROM moves WHERE id=?');
    $stmt2->execute([$result['previous_id']]);
    $result2 = $stmt2->fetch(\PDO::FETCH_ASSOC);

    $_SESSION['last_move'] = $result2['id'];
    connection\setState($result2['state']);

    return true;
}
