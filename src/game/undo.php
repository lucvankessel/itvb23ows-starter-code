<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

function undo_move($database) {
    $stmt = $database->prepare('SELECT * FROM moves WHERE id = ?');
    $stmt->execute([$_SESSION['last_move']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['last_move'] = $result['previous_id'];
    set_state($result['state']);

    // todo: remove the row from the database.

    // because we undo a move we also have to revert to the other player.
    $_SESSION['player'] = ($_SESSION['player'] == 0 ? 0 : 1);

    return true;
}