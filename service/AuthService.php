<?php

namespace petrvich\sendmail\service;

use \PDO;

class AuthService
{

    private PDO $connection;

    /**
     * LoadDataService constructor.
     */
    public function __construct() {
        $this->connection = ConnectionService::getConnection();
    }

    /**
     * @throws \Exception
     */
    public function authorizeUser(string $user, string $password): bool
    {
        $sql = 'SELECT `id`,`user`,`password` FROM `users` WHERE `user`=? AND `isActive`=? LIMIT 1';
        $q = $this->connection->prepare($sql);
        $q->execute([$user,true]);
        $row = $q->fetch();
        if (!is_array($row)) {
            throw new \Exception("No sender for client " . $user . ".");
        }

        if (sha1($password) === $row['password']) {
            return true;
        }

        throw new \Exception("Combination user and password is not correct.");
    }
}
