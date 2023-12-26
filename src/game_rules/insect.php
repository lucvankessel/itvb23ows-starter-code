<?php

include_once($_SERVER['DOCUMENT_ROOT']."/src/utils/util.php");

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
                    $to[] = ($pq[0] + $pq2[0]).','.($pq[1] + $pq2[1]);
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