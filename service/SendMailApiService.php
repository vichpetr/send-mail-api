<?php


namespace petrvich\sendmail\service;

use petrvich\sendmail\dto\ClientConfiguration;
use petrvich\sendmail\dto\InputRequest;
use petrvich\sendmail\dto\ResponseData;
use petrvich\sendmail\dto\SenderConfiguration;
use petrvich\sendmail\dto\Template;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class SendMailApiService
{

    private PHPMailer $mail;
    private InputRequest $request;

    /**
     * SendMailApiService constructor.
     * @param InputRequest $request
     */
    public function __construct(InputRequest $request)
    {
        $this->mail = new PHPMailer(true);
        $this->request = $request;
    }

    public function executeEmailSend(): ResponseData
    {
        try {
            $dataService = new DataService();
            $client = $dataService->loadClientConfiguration($this->request->getClientKey());
            $sender = $dataService->loadSenderConfiguration($client);
            $template = $dataService->loadTemplate($client, $this->request->getTemplateName());
            $this->prepareSmtpSender($sender);
            $this->prepareRecipient($client);
            $this->prepareContent($template);

            $send = $this->mail->send();
            $dataService->insertAuditLog($template, $send);
            return new ResponseData($send);
        } catch (\Exception $ex) {
            $responseData = new ResponseData(false);
            $responseData->setMessage($ex->getMessage());
            return $responseData;
        }
    }

    private function prepareSmtpSender(SenderConfiguration $sender): void
    {
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;
        $this->mail->isSMTP();
        $this->mail->Host = $sender->getHost();
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $sender->getUsername();
        $this->mail->Password = $sender->getPassword();
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = $sender->getPort();
        $this->mail->setFrom($sender->getUsername(), $sender->getSender());
    }

    private function prepareRecipient(ClientConfiguration $client): void
    {
        $this->mail->addAddress($client->getEmail(), $client->getName());
        $this->mail->addReplyTo($this->request->getSenderEmail(), $this->request->getSenderName());
    }

    private function prepareContent(Template $template): void
    {
        $message = $this->prepareMessageText($template->getTemplate());
        $this->mail->isHTML($template->isHtml());
        $this->mail->Subject = $template->getSubject();
        $this->mail->Body = $message;
        $this->mail->AltBody = strip_tags($message);
    }

    private function prepareMessageText(string $template): string
    {
        $result = $template;
        foreach ($this->request->getTemplateData() as $key => $value) {
            $result = str_replace('%' . $key . '%', $value, $result);
        }
        return $result;
    }

}
