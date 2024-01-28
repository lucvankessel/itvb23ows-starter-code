<?php
namespace game\pass;

require_once dirname(__FILE__).'/play.php';
require_once dirname(__FILE__) .'/move.php';
require_once dirname(__FILE__).'/../utils/util.php';

use db\connection;
use game\move;
use game\play;
use \insects;

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

function pass_move($database) {
    $player = $_SESSION['player'];
    $board = $_SESSION['board'];
    $hand = $_SESSION['hand'];
    if(!playerCanPass($board, $hand, $player)) {
        $_SESSION['ERROR'] = "player has a valid move it can play, no pass allowed!";
        return false;
    }
    
    $stmt = $database->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "pass", null, null, ?, ?)');
    $stmt->execute([$_SESSION['game_id'], $_SESSION['last_move'], connection\get_state()]);
    $_SESSION['last_move'] = $database->lastInsertId();
    $_SESSION['player'] = 1 - $_SESSION['player'];

    return true;
}

function playerCanPass($board, $hand, $player):bool {
    $to = insects\find_contour($board);

    // check if there is something on the board.
    if (!count($to)) {
        return false;
    }

    // check if the user cant play anything from their left tiles.
    foreach ($hand[$player] as $tile => $ct) {
        if ($ct == 0) {
            continue;
        }
        foreach($to as $pos) {
            if(play\isValidPlay($board, $hand, $player, $tile, $pos)) {
                return false;
            }
        }
    }

    // check if the player cant move any pieces they have on the board.
    foreach($board as $coord => $tile) {
        if($tile[0][0] == $player) {
            $moves = insects\get_moves($board, $coord);
            foreach($moves as $move) {
                if(move\isValidMove($board, $hand[$player], $player, $coord, $move)) {
                    return false;
                }
            }
        }
        continue;
    }

    return true;
}
