<?php declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class Database
{
    private Connection $connection;

    public function __construct()
    {
        $connectionParams = [
            'dbname' => $_ENV["DB_NAME"],
            'user' => $_ENV["USER"],
            'password' => $_ENV["PASSWORD"],
            'host' => $_ENV["HOST"],
            'driver' => 'pdo_mysql',
        ];

        $this->connection = DriverManager::getConnection($connectionParams);
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }
}
