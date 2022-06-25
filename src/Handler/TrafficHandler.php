<?php

namespace GloatingCord26\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TrafficHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $status = rand(0, 1) ? 'bad' : 'good';

        return new JsonResponse(
            [
                'status' => $status,
                'friendly' => "The traffic is {$status}",
            ]
        );
    }
}
