<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/src/utils/util.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/game_rules/insect.php';

$piece = $_POST['piece'];
$to = $_POST['to'];

$player = $_SESSION['player'];
$board = $_SESSION['board'];
$hand = $_SESSION['hand'][$player];

if (!$hand[$piece])
    $_SESSION['error'] = "Player does not have tile";
elseif (isset($board[$to]))
    $_SESSION['error'] = 'Board position is not empty';
elseif (count($board) && !hasNeighBour($to, $board))
    $_SESSION['error'] = "board position has no neighbour";
elseif (array_sum($hand) < 11 && !neighboursAreSameColor($player, $to, $board))
    $_SESSION['error'] = "Board position has opposing neighbour";
elseif (array_sum($hand) <= 8 && $hand['Q']) {
    $_SESSION['error'] = 'Must play queen bee';
} else {
    $_SESSION['board'][$to] = [[$_SESSION['player'], $piece]];
    $_SESSION['hand'][$player][$piece]--;
    $_SESSION['player'] = 1 - $_SESSION['player'];

    $db = database::getInstance()->get_connection();
    $state = get_state();
    try
    {    
        $stmt = $db->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "play", ?, ?, ?, ?)');
        $stmt->execute([$_SESSION['game_id'], $piece, $to, $_SESSION['last_move'] ?? null, $state]);
        $_SESSION['last_move'] = $db->lastInsertId();
    }
    catch (PDOException $e)
    {
        $_SESSION['error'] = 'Some error from PDO';
    }
}

header('Location: /');
exit(0);