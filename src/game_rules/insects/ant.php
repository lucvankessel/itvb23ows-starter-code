<?php
namespace insects\ant;

use \insects;

class Ant implements insects\Insect {
    public function moves(array $board, string $coordinate): array {
        // return find_contour($board, [$coordinate]);
        return insects\trace_contour($board, $coordinate, -1);
    }

    public function validMove(array $board, $from, $to): bool {
        $possible_moves = $this->moves($board, $from);
        if (in_array($to, $possible_moves)) {
            return true;
        }

        return False;
    }
}