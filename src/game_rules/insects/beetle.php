<?php
namespace insects\beetle;

use \insects;

class Beetle implements insects\Insect {
    public function moves(array $board, string $coordinate): array {
        // TODO: support stacking tiles.
        return insects\trace_contour($board, $coordinate, 1);
    }

    public function validMove(array $board, $from, $to):bool {
        $possible_moves = $this->moves($board, $from);
        if (in_array($to, $possible_moves)) {
            return true;
        }

        return False;
    }
}