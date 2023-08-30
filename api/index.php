<?php
require 'vendor/autoload.php'; // Assuming you have PHPMailer installed via Composer

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Define a simple array to store valid tokens
$validTokens = [
    'your-secret-token' // Replace with your secret token
];

// Middleware to check the token
$tokenMiddleware = function (Request $request, RequestHandler $handler, Response $response) use ($validTokens) {
    $token = $request->getHeaderLine('Authorization');

    if (!in_array($token, $validTokens)) {
        $response->getBody()->write('{error: "Unauthorized"}');
        $response->withStatus(401);
        return $response;
    }

    return $handler->handle($request);
};

// Add the token middleware to the send-email endpoint
$app->post('/send-email', function (Request $request, Response $response, $args) {
    $requestBody = $request->getBody();
    $responseBody = "{'request: $requestBody'}";
    $response->getBody()->write($responseBody);
    $response->withStatus(200);
    return $response;
})->add($tokenMiddleware);

// Define a health check endpoint
$app->get('/healthcheck', function (Request $request, Response $response, $args) {
    $response->getBody()->write("status: OK}");
    return $response;
});

$app->run();
