<?php

header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json, charset=utf-8');

use petrvich\sendmail\dto\InputRequest;
use petrvich\sendmail\service\SendMailApiService;

require_once '../service/autoload.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);
if(!is_array($data)) {
    $responseData = new \petrvich\sendmail\dto\ResponseData(false);
    $responseData->setMessage("wrong data input");
    echo json_encode($responseData);
    exit;
}
$request = new InputRequest($data);
$apiService = new SendMailApiService($request);
$response = $apiService->executeEmailSend();
echo json_encode($response);
