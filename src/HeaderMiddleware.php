<?php

namespace GloatingCord26;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HeaderMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $csp = "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; frame-src 'self'; worker-src 'self'; frame-ancestors 'self'; form-action 'self'; block-all-mixed-content; base-uri 'none'; manifest-src 'self'";

        $response = $handler->handle($request)
            ->withHeader('Server', 'web_server.bat')
            ->withHeader('X-Powered-By', 'HTML')
            ->withHeader('X-Frame-Options', 'DENY')
            ->withHeader('Content-Security-Policy', $csp)
            ->withHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->withHeader('Permissions-Policy', 'accelerometer=(), autoplay=(), camera=(), geolocation=(self), sync-xhr=(self), clipboard-write=(self)')
            ->withHeader('Strict-Transport-Security', 'max-age=15768000')
            ->withHeader('X-XSS-Protection', '1; mode=block')
            ->withHeader('X-Content-Type-Options', 'nosniff')
        ;

        $size = $response->getBody()->getSize();
        if (null === $size) {
            return $response;
        }

        return $response->withHeader('Content-Length', (string) $size);
    }
}
