<?php
class Db {
    public static function connect(){
        include_once(__DIR__."/../settings/settings.php");

        $dsn = 'mysql:host=' . SETTINGS['db']['host'] . ';dbname=' . SETTINGS['db']['db'];
        $pdo = new PDO($dsn, SETTINGS['db']['user'], SETTINGS['db']['password']);
        return $pdo;
    }
}