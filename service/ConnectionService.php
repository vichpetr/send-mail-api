<?php
declare(strict_types=1);

namespace petrvich\sendmail\service;

use \PDO;

class ConnectionService
{

    private string $servername;
    private string $dbname;
    private string $username;
    private string $pass;
    private int $port;

    public static function getConnection(): PDO
    {
        $dbConfig = parse_ini_file('db.ini', true);
        $connectionService = new ConnectionService($dbConfig['host'], (int)$dbConfig['port'], $dbConfig['database'], $dbConfig['username'], $dbConfig['password']);
        return $connectionService->connect();
    }

    private function __construct(string $servername, int $port, string $dbname, string $username, string $pass)
    {
        $this->servername = $servername;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->pass = $pass;
        $this->port = $port;
    }

    private function connect()
    {
        $dsn = "mysql:host=" . $this->servername . ";port=" . $this->port . ";dbname=" . $this->dbname;
        return new PDO($dsn, $this->username, $this->pass);
    }

}
