<?php
namespace db\connection;

function getState()
{
    return serialize([$_SESSION['hand'], $_SESSION['board'], $_SESSION['player']]);
}

function setState($state)
{
    list($a, $b, $c) = unserialize($state);
    $_SESSION['hand'] = $a;
    $_SESSION['board'] = $b;
    $_SESSION['player'] = $c;
}

interface DB
{
    public static function getInstance();
    public static function getConnection();
    public function insertMove(array $options): array;
    public function startGame(): bool;
    public function getMove(int $id): array;
    public function deleteMove(int $id): array;
    public function getLastInsert(): int;
}

class Database implements DB
{
    private static $instance = null;
    private static $db = null;

    public static function getInstance()
    {
      if (!self::$instance) {
        self::$instance = new database();
      }
     
      return self::$instance;
    }

    public static function getConnection()
    {
        if (self::$db == null) {
            self::$db = new \PDO('mysql:host=127.0.0.1;dbname=hive', 'root', '');
        }
        return self::$db;
    }

    function insertMove(array $options): array
    {
        if (count($options) != 6) {
            throw new \Exception("Not enough arugments to add a valid move");
        }
    
        $stmt = self::getConnection()->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, ?, ?, ?, ?, ?)');
        $stmt->execute($options);
    
        return $stmt->fetchall(\PDO::FETCH_ASSOC);
    }

    function startGame(): bool
    {
        return self::getConnection()->prepare("INSERT INTO games VALUES ()")->execute();
    }

    function getMove(int $id): array
    {
        $stmt = self::getConnection()->prepare("SELECT * FROM moves WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    function deleteMove(int $id): array
    {
        $stmt = self::getConnection()->prepare("DELETE FROM moves WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    function getLastInsert(): int
    {
        return self::getConnection()->lastInsertId();
    }
}
