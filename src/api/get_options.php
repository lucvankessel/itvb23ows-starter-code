<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/src/game_rules/insect.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/src/game/move.php';

use game\move;
use \insects;

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$board = $_SESSION['board'];

if(isset($_POST['from'])) {
    $selected = $_POST['from'];

    $valid_moves = [];
    $moves = insects\get_moves($board, $selected);
    foreach($moves as $move) {
        if(move\isValidMove($board, $_SESSION['hand'][$_SESSION['player']], $_SESSION['player'], $selected, $move)) {
            $valid_moves[] = $move;
        }
        unset($_SESSION['error']);
    }


    header("Content-Type: application/json");
    echo json_encode(insects\get_moves($board, $selected));
    exit();
}