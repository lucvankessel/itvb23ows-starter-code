<?php
namespace db\moves;

// function for inserting a move into the database
function insertMove($db, array $options)
{
    if (count($options) != 6) {
        throw new \Exception("Not enough arugments to add a valid move");
    }

    $stmt = $db->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?,?,?,?,?,?)');
    $stmt->execute($options);

    return $stmt->fetchall(\PDO::FETCH_ASSOC);
}
