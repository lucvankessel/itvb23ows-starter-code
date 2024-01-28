<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/moves.php';

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$db = database::getInstance()->get_connection();

$move_number;
try {
    $stmt = $db->prepare("SELECT COUNT(id) as 'count' FROM moves WHERE game_id = ?");
    $stmt->execute([$_SESSION['game_id']]);
    $result = $stmt->fetchall(PDO::FETCH_ASSOC);
    $move_number = $result[0]['count']; // TODO: get correct key.
} catch(PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: /');
    exit();
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

$ai_move = json_decode(httpPost($url, $data), true);
// This ai move we can put directly into the database.
// maybe make of the database insert a generic function.

$state = get_state();
$move_options = [$_SESSION['game_id'], $ai_move[0], $ai_move[1], $ai_move[2], $_SESSION['last_move']??null, $state];

$db = database::getInstance()->get_connection();
$insert_result = insert_move($db, $move_options);

// update board, update hand.
switch ($ai_move[0]) {
    case 'play':
        $_SESSION['board'][$ai_move[2]] = [[$_SESSION['player'], $ai_move[1]]];
        $_SESSION['hand'][$_SESSION['player']][$ai_move[1]]--;
        break;
    case 'move';
        $_SESSION['board'][$ai_move[2]] = array_pop($_SESSION['board'][$ai_move[1]]);
        unset($board[$ai_move[1]]);
        break;
}

$_SESSION['last_move'] = $insert_result['id'];
$_SESSION['player'] = 1 - $_SESSION['player'];

header('Location: /');
exit();

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