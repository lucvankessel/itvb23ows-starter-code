<?php

class Ant implements Insect {
    public function moves(array $board, string $coordinate): array {
        return find_contour($board, [$coordinate]);
    }
}