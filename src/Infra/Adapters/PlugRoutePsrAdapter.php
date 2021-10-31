<?php


declare(strict_types=1);


namespace App\Infra\Adapters;


use PlugRoute\Http\Request;
use PlugRoute\Http\Response;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Psr\Http\Message\RequestInterface as RequestPsr;
use Psr\Http\Message\ResponseInterface as ResponsePsr;


final class PlugRoutePsrAdapter
{
    public static function adapterRequest(Request $request): RequestPsr
    {
        return new GuzzleRequest(
            $request->method(),
            "http://localhost:8000/{$request->getUrl()}",
            array(
                'Content-Type', "application/json"
            ),
            json_encode($request->all())
        );
    }

    public static function adapterResponse(Response $response): ResponsePsr
    {
        return new GuzzleResponse();
    }
}
