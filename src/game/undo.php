<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/game/restart.php';

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

function undo_move($database) {
    $stmt = $database->prepare('SELECT * FROM moves WHERE id = ?');
    $stmt->execute([$_SESSION['last_move']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($result['previous_id'] == 0) {
        restart_game($database);
        return true;
    }

    $del_stmt = $database->prepare("DELETE FROM moves WHERE id=?");
    $del_stmt->execute([$result['id']]);

    $stmt2 = $database->prepare('SELECT * FROM moves WHERE id=?');
    $stmt2->execute([$result['previous_id']]);
    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    $_SESSION['last_move'] = $result2['id'];
    set_state($result2['state']);

    return true;
}