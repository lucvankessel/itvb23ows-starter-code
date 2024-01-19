<?php

class Queen implements Insect {
    public function moves(array $board, string $coordinate): array {
        return trace_contour($board, $coordinate, 1);
    }

    public function validMove(array $board, $from, $to): bool {
        return true;
    }
}