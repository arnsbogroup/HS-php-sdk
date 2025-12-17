<?php

namespace Heysender;

use Heysender\Enums\EventType;
use Heysender\HSClient;

class Webhook
{
    protected $client;

    /**
     * Initialize the Webhook client
     *
     * @param HSClient $hsClient HSClient Object
     */
    public function __construct(HSClient $hSClient)
    {
        $this->client = $hSClient;
    }

    /**
     * Get webhooks for a domain
     *
     * @param string $domain Domain name
     * @return array List of webhooks
     */
    public function getWebhooks(string $domain): array
    {
        return $this->client->request('GET', "/api/webhooks/{$domain}");
    }

    /**
     * Get specific webhook
     *
     * @param string $domain Domain name
     * @param int $webhookId Webhook ID
     * @return array Webhook data
     */
    public function getWebhook(string $domain, int $webhookId): array
    {
        return $this->client->request('GET', "/api/webhooks/{$domain}/{$webhookId}");
    }

    /**
     * Create webhook
     *
     * @param string $domain Domain name
     * @param string $url Webhook URL
     * @param array $events Event triggers
     * @return array Created webhook data
     */
    public function createWebhook(string $domain, string $url, array $events = []): array
    {
        $data = ['url' => $url];

        $eventStrings = array_map(
            fn($event) => $event instanceof EventType ? $event->value : $event,
            $events
        );

        foreach (EventType::values() as $event) {
            $data[$event] = in_array($event, $eventStrings);
        }

        return $this->client->request('POST', "/api/webhooks/{$domain}", $data);
    }

    /**
     * Update webhook
     *
     * @param string $domain Domain name
     * @param int $webhookId Webhook ID
     * @param string $url Webhook URL
     * @param array $events EventType
     * @return array Response data
     */
    public function updateWebhook(string $domain, int $webhookId, string $url, array $events = []): array
    {
        $data = ['url' => $url];

        $eventStrings = array_map(
            fn($event) => $event instanceof EventType ? $event->value : $event,
            $events
        );

        foreach (EventType::values() as $event) {
            $data[$event] = in_array($event, $eventStrings);
        }

        return $this->client->request('PUT', "/api/webhooks/{$domain}/{$webhookId}", $data);
    }

    /**
     * Delete webhook
     *
     * @param string $domain Domain name
     * @param int $webhookId Webhook ID
     * @return array Response data
     */
    public function deleteWebhook(string $domain, int $webhookId): array
    {
        return $this->client->request('DELETE', "/api/webhooks/{$domain}/{$webhookId}");
    }
}
