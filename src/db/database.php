<?php

function get_state() {
    return serialize([$_SESSION['hand'], $_SESSION['board'], $_SESSION['player']]);
}

function set_state($state) {
    list($a, $b, $c) = unserialize($state);
    $_SESSION['hand'] = $a;
    $_SESSION['board'] = $b;
    $_SESSION['player'] = $c;
}

class database {
    private static $instance = null;
    private static $db = null;

    public static function getInstance()
    {
      if(!self::$instance)
      {
        self::$instance = new database();
      }
     
      return self::$instance;
    }

    public static function get_connection() {
        if(self::$db == null) {
            self::$db = new PDO('mysql:host=127.0.0.1;dbname=hive', 'root', '');
        }
        return self::$db;
    }
}
?>