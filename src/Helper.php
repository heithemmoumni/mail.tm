<?php

namespace Mailtm;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

trait Helper
{
    /**
     * @param $path
     * @param string $method
     * @param string $body
     */
    public function send($path, $method = "GET", $body = ''): ResponseInterface
    {
        $headers = [
            'accept'        => "application/json",
            'authorization' => 'Bearer ' . $this->token
        ];

        if (in_array($method, ["POST", "PATCH"])) {
            $contentType = $method === "PATCH" ? "merge-patch+json" : "json";
            $headers["content-type"] = `application/${contentType}`;
            $body = json_encode($body);
        }
        return (new Client())->request($method, $path, ['headers' => $headers, 'body' => $body]);
    }
}
