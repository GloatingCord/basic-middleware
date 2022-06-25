<?php

namespace GloatingCord26\Handler;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundHandler implements RequestHandlerInterface
{
    public function __construct()
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->logger->error('nope', [
            'No-Page' => 'Page does not exist',
        ]);

        return new Response(404, [], 'hello');
    }
}
