<?php
class Db
{
    public static function connect()
    {
        try {
            include_once(__DIR__ . "/../settings/settings.php");

            $dsn = 'mysql:host=' . SETTINGS['db']['host'] . ';dbname=' . SETTINGS['db']['db'];
            $pdo = new PDO(
                $dsn,
                SETTINGS['db']['user'],
                SETTINGS['db']['password'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
            die(json_encode(array('outcome' => true, 'message' => 'Connected')));
        } catch (PDOException $ex) {
            die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
        }
    }
}
