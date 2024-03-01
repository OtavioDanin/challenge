<?php

declare(strict_types=1);
namespace App\Http;

interface HttpClientInterface
{
    public function sendGet(string $url, array $optionsRequest = []): object;
    public function sendPost(string $url, array $optionsRequest = []): object;
}