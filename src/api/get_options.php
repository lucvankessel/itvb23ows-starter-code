<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

include_once $_SERVER['DOCUMENT_ROOT'].'/src/game_rules/insect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/game/move.php';

$board = $_SESSION['board'];

if(isset($_POST['from'])) {
    $selected = $_POST['from'];

    $valid_moves = [];
    $moves = get_moves($board, $selected);
    foreach($moves as $move) {
        if(isValidMove($board, $_SESSION['hand'][$_SESSION['player']], $_SESSION['player'], $selected, $move)) {
            $valid_moves[] = $move;
        }
        unset($_SESSION['error']);
    }


    header("Content-Type: application/json");
    echo json_encode(get_moves($board, $selected));
    exit();
}