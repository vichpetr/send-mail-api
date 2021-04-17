<?php

namespace petrvich\sendmail\dto;

class Template {

    private int $id;
    private String $subject;
    private String $template;
    private String $templateName;
    private int $client;
    private bool $isHtml;

    public function __construct($row){
        $this->id = (int)$row['id'];
        $this->subject = $row['subject'];
        $this->template = $row['template'];
        $this->templateName = $row['templateName'];
        $this->client = (int)$row['client'];
        $this->isHtml = $row['type'] === 'html';
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
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return mixed|String
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return mixed|String
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * @return int|mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return bool
     */
    public function isHtml(): bool
    {
        return $this->isHtml;
    }

}
