<?php

require_once '../vendor/autoload.php';

use GloatingCord26\Middleware\AuthMiddleware;
use GloatingCord26\Middleware\Handler\TrafficHandler;
use GloatingCord26\Middleware\Handler\WeatherHandler;
use GloatingCord26\Middleware\HeaderMiddleware;
use GloatingCord26\Middleware\NotFoundMiddleware;
use GloatingCord26\Middleware\ResourceMiddleware;
use GloatingCord26\Middleware\RouteMiddleware;
use GloatingCord26\Middleware\SessionMiddleware;

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
$queue[] = new SessionMiddleware();
$queue[] = new NotFoundMiddleware();
$relay = new Relay\Relay($queue);

(new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($relay->handle($serverRequest));
