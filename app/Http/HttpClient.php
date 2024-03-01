<?php

declare(strict_types=1);

namespace App\Http;
use GuzzleHttp\Client;

class HttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    public function __construct(protected readonly Client $client)
    {
    }

    public function sendGet(string $url, array $optionsRequest = []): object
    {
        $response = $this->client->request('POST', $url, $optionsRequest);
        return (object)[
            'statusCode' => $response->getStatusCode(),
            'content' => $response->getBody()->getContents(),
            'headers' => $response->getHeaders()
        ];
    }

    public function sendPost(string $url, array $optionsRequest = []): object
    {
        $response = $this->client->request('GET', $url, $optionsRequest);
        return (object)[
            'statusCode' => $response->getStatusCode(),
            'content' => $response->getBody()->getContents(),
            'headers' => $response->getHeaders()
        ];
        
    }
}