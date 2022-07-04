<?php

namespace GloatingCord26\Middleware;

use GloatingCord26\Middleware\Handler\IndexHandler as HandlerIndexHandler;
use GloatingCord26\Middleware\Handler\NotFoundHandler as HandlerNotFoundHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteMiddleware implements MiddlewareInterface
{
    public function __construct(public string $basePath, public array $path = [])
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();

        if ('/' === $path) {
            $handler = new HandlerIndexHandler();

            return $handler->handle($request);
        }

        if (strpos($path, $this->basePath)) {
            $handler = new HandlerNotFoundHandler();

            return $handler->handle($request);
        }

        $path = substr($path, strlen($this->basePath));
        $path = trim($path, '/');
        $path = explode('/', $path);

        $routed = $request->withAttribute('route', $path[0]);

        if (isset($path[1])) {
            $routed = $routed->withAttribute('id', $path[1]);
        }

        return $handler->handle($routed);
    }
}
