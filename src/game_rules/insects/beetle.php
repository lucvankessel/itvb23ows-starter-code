<?php

class Beetle implements Insect {
    public function moves(array $board, string $coordinate): array {
        // TODO: support stacking tiles.
        return trace_contour($board, $coordinate, 1);
    }
}