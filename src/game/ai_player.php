<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/moves.php';

if(isset($_POST['ai_move'])) {
    $db = database::getInstance()->get_connection();

    $move_number;
    try {
        $stmt = $db->prepare("SELECT COUNT(m.id) FROM moves WHERE game_id = ?");
        $stmt->execute([$_SESSION['game_id']]);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        $move_number = $result; // TODO: get correct key.
    }

    $hand = $_SESSION['hand'];
    $board = $_SESSION['board'];

    $ai_obj = new stdClass();
    $ai_obj->move_number = $move_number;
    $ai_obj->hand = $hand;
    $ai_obj->board = $board;

    // make request to the AI
    $url = 'http://127.0.0.1:5000';
    $data = json_encode($ai_obj);

    $ai_move = httpPost($url, $data);
    // This ai move we can put directly into the database.
    // maybe make of the database insert a generic function.
    $state = get_state();
    $move_options = [$_SESSION['game_id'], $ai_move[0], $ai_move[1], $ai_move[2], $_SESSION['last_move']??null, $state];

    $db = database::getInstance()->get_connection();
    $insert_result = insert_move($db, $move_options);
    $_SESSION['last_move'] = $insert_result['id'];

    header('Location: /');
    exit();
}

function httpPost($url, $data)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}