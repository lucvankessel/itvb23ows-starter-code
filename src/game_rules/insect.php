<?php

require_once dirname(__FILE__) . "/../utils/util.php";
include_once 'insects/ant.php';
include_once 'insects/beetle.php';
include_once 'insects/grasshopper.php';
include_once 'insects/queen.php';
include_once 'insects/spider.php';

interface Insect
{
    /**
     * Return an array of possible moves the insect on the given coordinates can do.
     *
     * @param array $board
     * @param string $coordinates
     * @return array
     */
    public function moves(array $board, string $coordinate): array;

    public function validMove(array $board, $from, $to): bool;
}

function neighbours($coordinate) {
    $neighbours = [];
    foreach ($GLOBALS['OFFSETS'] as $pq) {
        $pq2 = explode(',', $coordinate);
        $neighbours[] = ($pq[0] + $pq2[0]) . ',' . ($pq[1] + $pq2[1]);
    }
    return $neighbours;
}

function find_contour($board, $exclude = []):array {
    $to = [];
    foreach ($GLOBALS['OFFSETS'] as $pq) {
        foreach (array_keys($board) as $pos) {
            
            if (!in_array($pos, $exclude)) {
                $pq2 = explode(',', $pos);
                if (hasNeighBour($pos, $board)) {
                    $new_pos = ($pq[0] + $pq2[0]).','.($pq[1] + $pq2[1]);
                    if( isset($board[$new_pos]) ) {
                        continue;
                    }
                    $to[] = $new_pos; 
                }
            }
        }
    }
    $to = array_unique($to);
    return $to;
}

function trace_contour($state, $coordinate, $steps = 1) {
    $contour = find_contour($state, [$coordinate]);

    $visited = [];
    $todo = [[$coordinate, 0]];
    $return = [];


    while ($todo) {
        [$c, $n] = array_pop($todo);
        foreach (neighbours($c) as $neighbour) {
            if (in_array($neighbour, $contour) && !in_array($neighbour, $visited) && !array_key_exists($neighbour, $state)) {
                $visited[] = $neighbour;
                if ($n == $steps) {
                        $return[] = $c;
                } else {
                    $todo[] = [$neighbour, $n + 1];
                }
            }
        }
    }

    return array_unique($return);
}

function get_moves($board, $coordinates): array {
    $insect_classes = [];
    $insect_classes['Q'] = new Queen;
    $insect_classes['B'] = new Beetle;
    $insect_classes['S'] = new Spider;
    $insect_classes['A'] = new Ant;
    $insect_classes['G'] = new Grasshopper;

    $moves = [];

    if ($coordinates != "") {
        $piece = $board[$coordinates][0][1];
        $class = $insect_classes[$piece];
        $moves = $class->moves($board, $coordinates);
    }

    return $moves;
}

/**
 * This function looks if there is a winning state on the board
 *
 * @param [array] $board
 * @return int, 0 = no win, 1 = white wins, 2 = black wins, 3 = draw
 */
function is_win($board): int {
    // behaviour: queen is not surrounded, queen is surrounded, both queens are surrounded.
    $return_value = 0;
    foreach ($board as $b => $st) {
        if ($st[0][1] == 'Q') {
            $neighbors = neighbours($b);
            if (!array_diff($neighbors, array_keys($board))) {
                if ($st[0][0] == 0) {
                    $return_value += 2;
                } else if ($st[0][0] == 1) {
                    $return_value += 1;
                }
            }
        }
    }

    return $return_value;
}