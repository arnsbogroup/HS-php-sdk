<?php

namespace Heysender;

use Heysender\HSClient;
use Heysender\Enums\SuppressionType;

class Suppression
{
    protected $client;

    /**
     * Initialize the Suppresion client
     *
     * @param HSClient $hsClient HSClient Object
     */
    public function __construct(HSClient $hSClient)
    {
        $this->client = $hSClient;
    }

    /**
     * Get suppressions by domain and type
     *
     * @param string $domain Domain name
     * @param string $type Suppression type (bounces, unsubscribes, complaints)
     * @return array Paginated suppression list
     */
    public function getSuppressions(string $domain, SuppressionType|string $type): array
    {
        $type = $type instanceof SuppressionType ? $type->value : $type;
        $validTypes = array_flip(SuppressionType::values());
        if(!isset($validTypes[$type])) {
            throw new HSException('Suppression Error: invalid type');
        }

        return $this->client->request('GET', "/api/suppressions/{$domain}/{$type}");
    }

    /**
     * Remove email from bounce suppressions
     *
     * @param string $domain Domain name
     * @param string $email Email address to remove
     * @return array Response data
     */
    public function removeBounce(string $domain, string $email): array
    {
        return $this->client->request('DELETE', "/api/suppressions/{$domain}/bounce/{$email}");
    }
}
