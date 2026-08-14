<?php

namespace Heysender;

use Heysender\HSClient;

class SmtpUser
{
    protected $client;

    /**
     * Initialize the SmtpUser client
     *
     * @param HSClient $hsClient HSClient Object
     */
    public function __construct(HSClient $hSClient)
    {
        $this->client = $hSClient;
    }

        /**
     * Get SMTP users for a domain
     *
     * @param int $domainId Domain ID
     * @return array List of SMTP users
     */
    public function getSMTPUsers(int $domainId): array
    {
        return $this->client->request('GET', "/api/smtp/{$domainId}");
    }

    /**
     * Get a single SMTP user
     *
     * Note: unlike getSMTPUsers(), this response includes a nested 'domain'
     * object, since the API eager-loads the related domain for this endpoint.
     *
     * @param int $domainId Domain ID
     * @param int $userId SMTP user ID
     * @return array SMTP user data
     */
    public function getSMTPUser(int $domainId, int $userId): array
    {
        return $this->client->request('GET', "/api/smtp/{$domainId}/{$userId}");
    }

    /**
     * Create SMTP user
     *
     * @param int $domainId Domain ID
     * @param string $smtpEmail SMTP email address
     * @param array $anonymizeOptions Anonymization options
     * @return array Created SMTP user with password
     */
    public function createSMTPUser(int $domainId, string $smtpEmail, array $anonymizeOptions = ['none']): array
    {
        return $this->client->request('POST', "/api/smtp/{$domainId}", [
            'smtp_email' => $smtpEmail,
            'anonymize_options' => $anonymizeOptions
        ]);
    }

    /**
     * Delete SMTP user
     *
     * @param int $domainId Domain ID
     * @param int $userId SMTP user ID
     * @return array Response data
     */
    public function deleteSMTPUser(int $domainId, int $userId): array
    {
        return $this->client->request('DELETE', "/api/smtp/{$domainId}/{$userId}");
    }

    /**
     * Generate new password for SMTP user
     *
     * @param int $domainId Domain ID
     * @param int $userId SMTP user ID
     * @return array New password data
     */
    public function resetSMTPPassword(int $domainId, int $userId): array
    {
        return $this->client->request('GET', "/api/smtp/{$domainId}/{$userId}/newpassword");
    }
}
