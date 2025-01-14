<?php
namespace game\play;

require_once dirname(__FILE__).'/../utils/util.php';
require_once dirname(__FILE__).'/../db/database.php';
require_once dirname(__FILE__).'/../game_rules/insect.php';

use util;
use db\connection;

if (!isset($_SESSION)) {
    session_start();
}

function playMove(connection\DB $database, $piece, $to)
{
    $player = $_SESSION['player'];
    $board = $_SESSION['board'];
    $hand = $_SESSION['hand'];

    if (isValidPlay($board, $hand, $player, $piece, $to)) {
        $_SESSION['board'][$to] = [[$_SESSION['player'], $piece]];
        $_SESSION['hand'][$player][$piece]--;
        $_SESSION['player'] = 1 - $_SESSION['player'];

        $state = connection\getState();
        try {
            $database->insertMove([$_SESSION['game_id'], "play", $piece, $to, $_SESSION['last_move'] ?? null, $state]);
            $_SESSION['last_move'] = $database->getLastInsert();
        } catch (\PDOException $e) {
            $_SESSION['error'] = $e;
            $_SESSION['error'] = 'Some error from PDO';
        }
        return true;
    } else {
        return false;
    }
}

function isValidPlay($board, $hand, $player, $piece, $to): bool
{
    $hand = $hand[$player];

    if (!$hand[$piece]) {
        $_SESSION['error'] = "Player does not have tile";
        return false;
    }elseif (isset($board[$to])) {
        $_SESSION['error'] = 'Board position is not empty';
        return false;
    }elseif (count($board) && !util\hasNeighBour($to, $board)) {
        $_SESSION['error'] = "board position has no neighbour";
        return false;
    }elseif (array_sum($hand) < 11 && !util\neighboursAreSameColor($player, $to, $board)) {
        $_SESSION['error'] = "Board position has opposing neighbour";
        return false;
    }elseif (array_sum($hand) <= 8 && $hand['Q'] && $piece != 'Q') {
        $_SESSION['error'] = 'Must play queen bee';
        return false;
    }

    return true;
}

function isValidPlayTile($board, $hand, $player, $to)
{
    if (isset($board[$to])) {
        return false;
    }elseif (count($board) && !util\hasNeighBour($to, $board)) {
        return false;
    }elseif (array_sum($hand) < 11 && !util\neighboursAreSameColor($player, $to, $board)) {
        return false;
    }

    return true;
}
