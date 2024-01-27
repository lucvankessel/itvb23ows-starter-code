<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/game/restart.php';

$db = database::getInstance()->get_connection();

if (restart_game($db)) {
    header('Location: /');
    exit(0);
} else {
    $_SESSION['error'] = "Could not restart game";
    header("Location: /");
    exit(0);
}