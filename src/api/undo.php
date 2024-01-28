<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/src/game/undo.php';

use db\connection;
use game\undo;

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$database = connection\database::getInstance()->get_connection();

if (undo\undo_move($database)) {
    header('Location: /');
    exit(0);
} else {
    $_SESSION['error'] = "Could not undo move";
    header("Location: /");
    exit(0);
}