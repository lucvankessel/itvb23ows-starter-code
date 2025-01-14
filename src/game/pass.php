<?php
namespace game\pass;

require_once dirname(__FILE__).'/play.php';
require_once dirname(__FILE__) .'/move.php';
require_once dirname(__FILE__).'/../utils/util.php';

use db\connection;
use game\move;
use game\play;
use \insects;

if (!isset($_SESSION)) {
    session_start();
}

function passMove(connection\DB $database)
{
    $player = $_SESSION['player'];
    $board = $_SESSION['board'];
    $hand = $_SESSION['hand'];
    if (!playerCanPass($board, $hand, $player)) {
        $_SESSION['ERROR'] = "player has a valid move it can play, no pass allowed!";
        return false;
    }

    $database->insertMove([$_SESSION['game_id'], "pass", null, null, $_SESSION['last_move'], connection\getState()]);
    $_SESSION['last_move'] = $database->getConnection()->lastInsertId();
    $_SESSION['player'] = 1 - $_SESSION['player'];

    return true;
}

function playerCanPass($board, $hand, $player):bool
{
    $to = insects\findContour($board);

    // check if there is something on the board.
    if (!count($to)) {
        return false;
    }

    // check if the user cant play anything from their left tiles.
    foreach ($hand[$player] as $tile => $ct) {
        if ($ct == 0) {
            continue;
        }
        foreach ($to as $pos) {
            if (play\isValidPlay($board, $hand, $player, $tile, $pos)) {
                return false;
            }
        }
    }

    // check if the player cant move any pieces they have on the board.
    foreach ($board as $coord => $tile) {
        if ($tile[0][0] == $player) {
            $moves = insects\getMoves($board, $coord);
            foreach ($moves as $move) {
                if (move\isValidMove($board, $hand[$player], $player, $coord, $move)) {
                    return false;
                }
            }
        }
    }

    return true;
}
