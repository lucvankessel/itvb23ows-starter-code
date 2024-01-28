<?php
namespace insects\grasshopper;

use \insects;

class Grasshopper implements insects\Insect {
    public function moves(array $board, string $coordinate): array {
        $possible_moves = [];

        // loop over the globals.
        foreach ($GLOBALS['OFFSETS'] as $key => $pq) {
            $jumps=0;
            $coords = explode(',', $coordinate);;

            while(true) {
                $p = $coords[0] + $pq[0];
                $q = $coords[1] + $pq[1];

                $coords = [$p, $q];

                if(!array_key_exists($p.",".$q, $board)) {
                    if ($jumps == 0) {
                        break;
                    }
                    $possible_moves[] = $p.",".$q;
                        break;
                }
                $jumps++;
            }
        }
        
        return $possible_moves;
    }

    public function validMove(array $board, $from, $to): bool {
        $possible_moves = $this->moves($board, $from);
        if (in_array($to, $possible_moves)) {
            return true;
        }

        return False;
    }
}