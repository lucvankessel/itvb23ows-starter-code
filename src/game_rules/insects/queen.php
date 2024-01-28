<?php
namespace insects\queen;

use \insects;

class Queen implements insects\Insect
{
    public function moves(array $board, string $coordinate): array
    {
        return insects\traceContour($board, $coordinate, 1);
    }

    public function validMove(array $board, $from, $to): bool
    {
        $possibleMoves = $this->moves($board, $from);
        if (in_array($to, $possibleMoves)) {
            return true;
        }

        return false;
    }
}
