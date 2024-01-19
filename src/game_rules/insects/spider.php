<?php

class Spider implements Insect {
    public function moves(array $board, string $coordinate): array {
        return trace_contour($board, $coordinate, 3);
    }

    public function validMove(array $board, $from, $to): bool {
        return true;
    }
}