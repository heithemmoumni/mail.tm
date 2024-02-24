<?php

namespace Mailtm;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Mailtm
{
    use Helper;
    /**
     * @var string
     */
    private string $baseUrl;
    /**
     * @var string
     */
    private string $id;


    /**
     * @var string
     */
    private string $address;
    /**
     * @var string
     */
    private string $token;

    public function __construct()
    {
        $this->baseUrl = "https://api.mail.tm";
    }

    /**
     * Summary of register
     * @param string $address
     * @param string $password
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function register(string $address, string $password): ResponseInterface
    {
        return $this->send("/accounts", "POST", ['address' => $address, 'password' => $password]);
    }

    /**
     * @param string $address
     * @param string $password
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function login(string $address, string $password): ResponseInterface
    {
        $res = $this->send("/token", "POST", ['address' => $address, 'password' => $password]);

        $body = json_decode($res->getBody());

        if ($body) {
            $this->token = $body->token;
            $this->id = $body->id;
        }

        return $res;
    }

    /**
     * Summary of me
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function me()
    {
        return $this->send("/me");
    }

    /**
     * @param $accountId
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getAccount($accountId): ResponseInterface
    {
        return $this->send("/accounts/$accountId");
    }

    /**
     * @param $accountId
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function deleteAccount($accountId): ResponseInterface
    {
        return $this->send("/accounts/$accountId", "DELETE");
    }

    /**
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function deleteMe(): ResponseInterface
    {
        return $this->deleteAccount($this->id);
    }

    /**
     * Retrieves the collection of Domain resources.
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getDomains(): ResponseInterface
    {
        return $this->send("/domains?page=1");
    }

    /**
     * Retrieves a Domain resource.
     * @param $domainId
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getDomain($domainId): ResponseInterface
    {
        return $this->send("/domains/$domainId");
    }

    /**
     * Retrieves the collection of Message resources.
     *
     * @param int $page
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getMessages(int $page = 1): ResponseInterface
    {
        return $this->send("/messages?page=$page");
    }

    /**
     * Retrieves a Message resource.
     * @param $messageId Resource identifier
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getMessage($messageId): ResponseInterface
    {
        return $this->send("/messages/$messageId");
    }

    /**
     * Removes the Message resource.
     * @param $messageId
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function deleteMessage($messageId): ResponseInterface
    {
        return $this->send("/messages/$messageId", "DELETE");
    }

    /**
     * Sets a message as read or unread.
     * @param string $messageId Resource identifier
     * @param bool $seen Default true
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function setMessageSeen(string $messageId, bool $seen = true): ResponseInterface
    {
        return $this->send("/messages/$messageId", "PATCH", [$seen]);
    }

    /**
     * @param $sourceId
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getSource($sourceId): ResponseInterface
    {
        return $this->send("/sources/$sourceId");
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function setBaseUrl(string $baseUrl): Mailtm
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Mailtm
    {
        $this->id = $id;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): Mailtm
    {
        $this->token = $token;
        return $this;
    }
}