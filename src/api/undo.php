<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/game/undo.php';

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$database = database::getInstance()->get_connection();

if (undo_move($database)) {
    header('Location: /');
    exit(0);
} else {
    $_SESSION['error'] = "Could not undo move";
    header("Location: /");
    exit(0);
}