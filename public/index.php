<?php

require_once '../vendor/autoload.php';

// Instanciate ANY PSR-17 factory implementations. Here is nyholm/psr7 as an example
$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();

if ('/' === $serverRequest->getUri()->getPath()) {
    $responseBody = $psr17Factory->createStream('Hello world');
    $response = $psr17Factory->createResponse(200)->withBody($responseBody);
}

if ('/so' === $serverRequest->getUri()->getPath()) {
    $responseBody = $psr17Factory->createStream('Hello world from so');
    $response = $psr17Factory->createResponse(200)->withBody($responseBody);
}

if ('/api/v2' === $serverRequest->getUri()->getPath()) {
    $responseBody = $psr17Factory->createStream('this is an api');
    $response = $psr17Factory->createResponse(200)->withAddedHeader('Authorization', 'Nothing to see here')->withBody($responseBody);
}

if (!isset($response)) {
    $responseBody = $psr17Factory->createStream('Page not found');
    $response = $psr17Factory->createResponse(404)->withBody($responseBody);
}

(new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
