<?php

namespace petrvich\sendmail\service;

use PDO;
use petrvich\sendmail\dto\ClientConfiguration;
use petrvich\sendmail\dto\SenderConfiguration;
use petrvich\sendmail\dto\Template;

class DataService
{

    private PDO $connection;

    /**
     * LoadDataService constructor.
     */
    public function __construct()
    {
        $this->connection = ConnectionService::getConnection();
    }

    /**
     * @throws \Exception
     */
    public function loadSenderConfiguration(ClientConfiguration $client): SenderConfiguration
    {
        $sql = 'SELECT `id`,`key`,`host`,`port`,`sender`,`username`,`password` FROM `sender` WHERE `id`=? LIMIT 1';
        $q = $this->connection->prepare($sql);
        $q->execute([$client->getSenderId()]);
        $row = $q->fetch();
        if (!is_array($row)) {
            throw new \Exception("No sender for client " . $client->getName() . ".");
        }
        return new SenderConfiguration($row);
    }

    /**
     * @throws \Exception
     */
    public function loadClientConfiguration(string $key): ClientConfiguration
    {
        $sql = "SELECT `id`,`key`,`senderId`,`name`,`email` FROM `client` WHERE `key`=? LIMIT 1";
        $q = $this->connection->prepare($sql);
        $q->execute([$key]);

        $row = $q->fetch();
        if (!is_array($row)) {
            throw new \Exception("No client for " . $key . ".");
        }
        return new ClientConfiguration($row);
    }

    /**
     * @throws \Exception
     */
    public function loadTemplate(ClientConfiguration $client, string $templateName = 'default'): Template
    {
        $sql = 'SELECT `id`,`templateName`,`template`,`subject`,`client`,`type` FROM `template` WHERE `client`=? AND `templateName`=? LIMIT 1';
        $q = $this->connection->prepare($sql);
        $q->execute([$client->getId(), $templateName]);

        $row = $q->fetch();
        if (!is_array($row)) {
            throw new \Exception("No template for " . $client->getName() . " and $templateName");
        }
        return new Template($row);
    }

    public function insertAuditLog(Template $template, bool $send): void
    {
        $sql = "INSERT INTO audit (template, result) VALUES (?,?)";
        $stmt= $this->connection->prepare($sql);
        $stmt->execute([$template->getId(), $send]);
    }
}
