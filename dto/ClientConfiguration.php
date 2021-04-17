<?php

namespace petrvich\sendmail\dto;

class ClientConfiguration {

    private int $id;
    private String $key;
    private String $name;
    private String $email;
    private int $senderId;

    public function __construct($row) {
        $this->id = (int)$row['id'];
        $this->key = $row['key'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->senderId = (int)$row['senderId'];
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed|String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int|mixed
     */
    public function getSenderId()
    {
        return $this->senderId;
    }
}
