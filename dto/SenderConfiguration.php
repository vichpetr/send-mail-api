<?php

namespace petrvich\sendmail\dto;

class SenderConfiguration {

    private int $id;
    private String $host;
    private int $port;
    private String $sender;
    private String $username;
    private String $password;

    public function __construct($row) {
        $this->id = (int)$row['id'];
        $this->host = $row['host'];
        $this->port = (int)$row['port'];
        $this->sender = $row['sender'];
        $this->username = $row['username'];
        $this->password = $row['password'];
    }

    /**
     * @return int|mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed|String
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return mixed|String
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return int|mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return mixed|String
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return mixed|String
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed|String
     */
    public function getPassword()
    {
        return $this->password;
    }
}
