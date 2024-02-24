<?php

namespace Mailtm;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

trait Helper
{
    /**
     * @var Client
     */
    private Client $httpClient;

    // Other properties and methods...

    /**
     * Sets the HTTP client.
     *
     * @param Client $client
     */
    public function setHttpClient(Client $client): void
    {
        $this->httpClient = $client;
    }

    /**
     * @param $path
     * @param string $method
     * @param array $body
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function send($path, string $method = "GET", array $body = []): ResponseInterface
    {
        $headers = [
            'accept'        => "application/json",
            'authorization' => 'Bearer ' . $this->token
        ];

        if (in_array($method, ["POST", "PATCH"])) {
            $contentType = $method === "PATCH" ? "merge-patch+json" : "json";
            $headers["content-type"] = "application/{$contentType}";
            $body = json_encode($body);
        }
        return $this->httpClient->request($method, $path, ['headers' => $headers, 'body' => $body]);
    }
}
