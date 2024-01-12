<?php

function start_game($db) {
    $stmt = $db->prepare('INSERT INTO games VALUES ()');
    $stmt->execute();
    $result = $stmt->fetchall(PDO::FETCH_ASSOC);

    return $result;
}