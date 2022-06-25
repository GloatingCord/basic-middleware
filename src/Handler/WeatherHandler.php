<?php

namespace GloatingCord26\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class WeatherHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $options = [
            'c' => 'cloudy',
            'r' => 'rainy',
            's' => 'sunny',
        ];

        $icon = array_rand($options);

        return new JsonResponse(
            [
                'status' => $options[$icon],
                'friendly' => 'The weather is '.$options[$icon],
            ]
        );
    }
}
