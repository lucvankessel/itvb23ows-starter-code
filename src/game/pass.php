<?php

function pass_move($database) {
    session_start();
    
    $stmt = $database->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "pass", null, null, ?, ?)');
    $stmt->execute([$_SESSION['game_id'], $_SESSION['last_move'], get_state()]);
    $_SESSION['last_move'] = $database->lastInsertId();
    $_SESSION['player'] = 1 - $_SESSION['player'];

    return true;
}
