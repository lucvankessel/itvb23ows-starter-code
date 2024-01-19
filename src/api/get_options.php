<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/src/game_rules/insect.php';

$board = $_SESSION['board'];

if(isset($_POST['from'])) {
    $selected = $_POST['from'];

    header("Content-Type: application/json");
    echo json_encode(get_moves($board, $selected));
    exit();
}