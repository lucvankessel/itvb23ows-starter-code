<?php

class Ant implements Insect {
    public function moves(array $board, string $coordinate): array {
        return find_contour($board, [$coordinate]);
    }

    public function validMove(array $board, $from, $to): bool {
        return true;
    }
}