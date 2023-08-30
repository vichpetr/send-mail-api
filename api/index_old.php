<?php

header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json, charset=utf-8');

use petrvich\sendmail\dto\InputRequest;
use petrvich\sendmail\dto\ResponseData;
use petrvich\sendmail\service\AuthService;
use petrvich\sendmail\service\SendMailApiService;

require_once '../service/autoload.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.0 409 Unsupported method');
    exit;
}

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    exit;
} else {
    $authService = new AuthService();
    try {
        $authorizeUser = $authService->authorizeUser($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
        echo "Auth user result is: " . $authorizeUser;
    } catch (Exception $e) {
        header('HTTP/1.0 401 Unauthorized');
        echo $e->getMessage();
        exit;
    }
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (!is_array($data)) {
    $responseData = new ResponseData(false);
    $responseData->setMessage("wrong data input");
    echo json_encode($responseData);
    exit;
}
$request = new InputRequest($data);
$apiService = new SendMailApiService($request);
$response = $apiService->executeEmailSend();
echo json_encode($response);
