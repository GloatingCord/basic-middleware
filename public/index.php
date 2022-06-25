<?php

require_once '../vendor/autoload.php';

use GloatingCord26\AuthMiddleware;
use GloatingCord26\Handler\TrafficHandler;
use GloatingCord26\Handler\WeatherHandler;
use GloatingCord26\HeaderMiddleware;
use GloatingCord26\ResourceMiddleware;
use GloatingCord26\RouteMiddleware;
use GloatingCord26\SessionMiddleware;

// Instanciate ANY PSR-17 factory implementations. Here is nyholm/psr7 as an example
$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();

$queue[] = new AuthMiddleware(
    [
        'Authorization' => 'secret',
    ]
);
$queue[] = new HeaderMiddleware();
$queue[] = new SessionMiddleware();
$queue[] = new RouteMiddleware('');
$queue[] = new ResourceMiddleware(
    [
        'traffic' => new TrafficHandler(),
        'weather' => new WeatherHandler(),
    ]
);

$relay = new Relay\Relay($queue);

(new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($relay->handle($serverRequest));
