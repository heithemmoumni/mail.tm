<?php

namespace Mailtm\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mailtm\Mailtm;
use PHPUnit\Framework\TestCase;

class MailtmTest extends TestCase
{
    private Mailtm $mailtm;

    protected function setUp(): void
    {
        // Create a mock HTTP client
        $mockHandler = new MockHandler([
            new Response(200, [], '{"status": true, "message": "Account created"}'),
            new Response(200, [], '{"status": true, "message": "Account data retrieved"}'),
            new Response(200, [], '{"status": true, "message": "Messages listed"}'),
            new Response(200, [], '{"status": true, "message": "Logged in with token"}'),
            new Response(200, [], '{"status": true, "message": "Listener tested"}'),
            new Response(200, [], '{"status": true, "message": "Account deleted"}'),
            // Add more mock responses as needed for other methods
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $httpClient = new Client(['handler' => $handlerStack]);

        // Inject the mock HTTP client into Mailtm class
        $this->mailtm = new Mailtm();
        $this->mailtm->setHttpClient($httpClient);

        $this->mailtm->setToken('hsddlcsncjdncdjnjcd')
        ->setId('az');
        ;
    }

    /**
     * @throws GuzzleException
     */
    public function testCreateOneAccount()
    {
        $response = $this->mailtm->register('test@example.com', 'password');
        $this->assertEquals(200, $response->getStatusCode());
    }

}
