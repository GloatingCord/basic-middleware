<?php

namespace GloatingCord26\Middleware\Handler;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TrafficHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $status = rand(0, 1) ? 'bad' : 'good';

        return new Response(200, [], 'hello trafic is '.$status);
    }
}
