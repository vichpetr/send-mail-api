<?php

namespace petrvich\sendmail\dto;

class ResponseData {

    public bool $success;
    public \DateTime $dateTime;
    public String $message;

    /**
     * ResponseData constructor.
     * @param bool $success
     */
    public function __construct(bool $success)
    {
        $this->success = $success;
        $this->dateTime = new \DateTime();
    }

    /**
     * @return String
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param String $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

}
