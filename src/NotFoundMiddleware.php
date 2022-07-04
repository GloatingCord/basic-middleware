<?php

namespace GloatingCord26\Middleware;

use GloatingCord26\Middleware\Handler\NotFoundHandler as HandlerNotFoundHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundMiddleware implements MiddlewareInterface
{
    public function __construct(private array $keys = [])
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ('/so' === $request->getUri()->getPath()) {
            $handler = new HandlerNotFoundHandler();
        }

        return $handler->handle($request);
    }
}
