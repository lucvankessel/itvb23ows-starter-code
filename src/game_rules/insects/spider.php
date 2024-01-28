<?php
namespace insects\spider;

use \insects;

class Spider implements insects\Insect {
    public function moves(array $board, string $coordinate): array {
        return insects\trace_contour($board, $coordinate, 3);
    }

    public function validMove(array $board, $from, $to): bool {
        $possible_moves = $this->moves($board, $from);
        if (in_array($to, $possible_moves)) {
            return true;
        }

        return False;
    }
}