<?php

interface Insect
{
    /**
     * Return an array of possible moves the insect on the given coordinates can do.
     *
     * @param array $board
     * @param array $coordinates
     * @return array
     */
    public function moves($board, $coordinates): array;
}