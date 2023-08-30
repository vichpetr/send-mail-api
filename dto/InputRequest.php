<?php


namespace petrvich\sendmail\dto;


class InputRequest
{
    private string $clientKey;
    private string $templateName;
    private array $templateData;
    private string $senderName;
    private string $senderEmail;
    private string $authToken;

    /**
     * InputRequest constructor.
     */
    public function __construct($data)
    {
        $this->clientKey = $data['client'];
        $this->templateName = $data['template'] ?? 'default';
        $this->templateData = $data['data'] ?? [];
        $this->senderName = $data['name'];
        $this->senderEmail = $data['email'];
        $this->authToken = $data['token'];
    }

    /**
     * @return mixed|string
     */
    public function getClientKey()
    {
        return $this->clientKey;
    }

    /**
     * @return mixed|string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * @return array|mixed
     */
    public function getTemplateData()
    {
        return $this->templateData;
    }

    /**
     * @return mixed|string
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * @return mixed|string
     */
    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    /**
     * @return mixed|string
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }
}
