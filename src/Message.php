<?php

namespace Heysender;

use Heysender\HSClient;

class Message
{
    protected $client;

    /**
     * Initialize the Message client
     *
     * @param HSClient $hsClient HSClient Object
     */
    public function __construct(HSClient $hSClient)
    {
        $this->client = $hSClient;
    }
    /**
     * Send an email message
     *
     * @param array $messageData Message data array
     * @return array Message response with status and message IDs
     */
    public function sendMessage(array $messageData): array
    {
        return $this->client->request('POST', '/api/message', $messageData);
    }

    /**
     * Get message information
     *
     * @param string $messageId Message ID
     * @return array Message information
     */
    public function getMessage(string $messageId): array
    {
        return $this->client->request('GET', "/api/message/{$messageId}");
    }

    /**
     * Get message information for specific recipient
     *
     * @param string $messageId Message ID
     * @param string $recipient Recipient email
     * @return array Message information
     */
    public function getMessageByRecipient(string $messageId, string $recipient): array
    {
        return $this->client->request('GET', "/api/message/{$messageId}/{$recipient}");
    }
}
