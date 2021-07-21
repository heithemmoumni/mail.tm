<?php

namespace Mailtm;

use Psr\Http\Message\ResponseInterface;

class Mailtm
{
    use Helper;

    /**
     * @var string
     */
    private $baseUrl;
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $address;
    /**
     * @var string
     */
    private $token;

    public function __construct()
    {
        $this->baseUrl = "https://api.mail.tm";
        $this->token = "";
        $this->id = "";
        $this->address = "";
    }


    public function register($address, $password)
    {
        return $this->send("/accounts", "POST", [$address, $password]);
    }

    /**
     * @param $address
     * @param $password
     * @return ResponseInterface
     */
    public function login($address, $password)
    {
        $res = $this->send("/token", "POST", [$address, $password]);

        if ($res) {
            $this->token = $res->token;
            $this->id = $res->id;
        }

        return $res;
    }

    public function me()
    {
        return $this->send("/me");
    }

    public function getAccount($accountId)
    {
        return $this->send("/accounts/$accountId");
    }

    public function deleteAccount($accountId)
    {
        return $this->send("/accounts/$accountId", "DELETE");
    }

    public function deleteMe()
    {
        return $this->deleteAccount($this->id);
    }

    /**
     * Retrieves the collection of Domain resources.
     */
    public function getDomains()
    {
        return $this->send("/domains?page=1");
    }

    /**
     * Retrieves a Domain resource.
     * @param $domainId
     * @return ResponseInterface
     */
    public function getDomain($domainId)
    {
        return $this->send("/domains/$domainId");
    }

    /**
     * Retrieves the collection of Message resources.
     * @param int $page
     * @return ResponseInterface
     */
    public function getMessages($page = 1)
    {
        return $this->send("/messages?page=$page");
    }

    /**
     * Retrieves a Message resource.
     * @param $messageId Resource identifier
     * @return ResponseInterface
     */
    public function getMessage($messageId)
    {
        return $this->send("/messages/$messageId");
    }

    /**
     * Removes the Message resource.
     * @return ResponseInterface
     */
    public function deleteMessage($messageId)
    {
        return $this->send("/messages/$messageId", "DELETE");
    }

    /**
     * Sets a message as read or unread.
     * @param string $messageId Resource identifier
     * @param bool $seen Default true
     */
    public function setMessageSeen($messageId, $seen = true)
    {
        return $this->send("/messages/$messageId", "PATCH", $seen);
    }


    public function getSource($sourceId)
    {
        return $this->send("/sources/$sourceId");
    }
}
