<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/src/utils/util.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/db/database.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/game_rules/insect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/src/game/play.php';

$piece = $_POST['piece'];
$to = $_POST['to'];
$db = database::getInstance()->get_connection();

// right now the play_move sets the errors so we can just redirect to index.php
play_move($db, $piece, $to);
Header('Location: /');
exit(0);