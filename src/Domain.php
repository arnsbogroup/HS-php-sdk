<?php

namespace Heysender;

use Heysender\HSClient;

class Domain
{
    protected $client;

    /**
     * Initialize the Domain client
     *
     * @param HSClient $hsClient HSClient Object
     */
    public function __construct(HSClient $hSClient)
    {
        $this->client = $hSClient;
    }

    /**
     * Get list of domains
     *
     * @return array List of domains
     */
    public function getDomains(): array
    {
        return $this->client->request('GET', '/api/domains');
    }

    /**
     * Create a new domain
     *
     * @param string $url Domain URL
     * @param string|null $customSelector Custom DKIM selector (optional)
     * @param string|null $dkimKey Custom DKIM private key (optional)
     * @return array Created domain data
     */
    public function createDomain(string $url, ?string $customSelector = null, ?string $dkimKey = null): array
    {
        $data = ['url' => $url];

        if ($customSelector) {
            $data['custom_selector'] = $customSelector;
        }

        if ($dkimKey) {
            $data['dkim_key'] = $dkimKey;
        }

        return $this->client->request('POST', '/api/domains', $data);
    }

    /**
     * Get a single domain by its URL
     *
     * @param string $domain Domain name
     * @return array Domain data
     */
    public function getDomain(string $domain): array
    {
        return $this->client->request('GET', "/api/domains/{$domain}");
    }

    /**
     * Update domain with new DKIM key
     *
     * @param string $domain Domain name
     * @param string $dkimKey New DKIM private key
     * @return array Response data
     */
    public function updateDomain(string $domain, string $dkimKey): array
    {
        return $this->client->request('PUT', "/api/domains/{$domain}", [
            'dkim_key' => $dkimKey
        ]);
    }

    /**
     * Delete a domain
     *
     * @param string $domain Domain name
     * @return array Response data
     */
    public function deleteDomain(string $domain): array
    {
        return $this->client->request('DELETE', "/api/domains/{$domain}");
    }

    /**
     * Validate domain SPF and DKIM
     *
     * @param string $domain Domain name
     * @return array Validation status
     */
    public function validateDomain(string $domain): array
    {
        return $this->client->request('GET', "/api/domains/{$domain}/validate");
    }
}
