<?php

namespace GloatingCord26\Middleware;

use GloatingCord26\Middleware\Handler\NotFoundHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ResourceMiddleware implements MiddlewareInterface
{
    public function __construct(private array $handlers)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $request->getAttribute('route');

        if (!$route || !isset($this->handlers[$route]) || !($this->handlers[$route] instanceof RequestHandlerInterface)) {
            $handler = new NotFoundHandler();

            return $handler->handle($request);
        }

        return $this->handlers[$route]->handle($request);
    }
}
