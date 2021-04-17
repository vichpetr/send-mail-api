<?php

use petrvich\sendmail\dto\InputRequest;
use petrvich\sendmail\service\SendMailApiService;

require_once '../service/autoload.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$request = new InputRequest($data);
$apiService = new SendMailApiService($request);
$response = $apiService->executeEmailSend();
echo json_encode($response);
