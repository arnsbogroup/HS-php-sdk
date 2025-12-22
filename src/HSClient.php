<?php

namespace Heysender;

use Heysender\HSException;

class HSClient
{
    private string $apiKey;
    private string $apiSecret;
    private string $baseUrl = 'https://app.heysender.com';
    private array $lastResponse = [];

    /**
     * Initialize the Heysender client
     *
     * @param string $apiKey Your Heysender API key
     * @param string $apiSecret Your Heysender API secret
     */
    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Make an HTTP request to the API
     *
     * @param string $method HTTP method (GET, POST, PUT, DELETE)
     * @param string $endpoint API endpoint
     * @param array $data Request data
     * @return array Response data
     * @throws HSException
     */
    public function request(string $method, string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . $endpoint;
        $headers = [
            'Authorization: Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret),
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: heysender-api-sdk/1.0'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if (!empty($data) && in_array($method, ['POST', 'PUT'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        if ($error) {
            throw new HSException("cURL Error: {$error}");
        }
        unset($ch);

        $this->lastResponse = [
            'http_code' => $httpCode,
            'body' => $response
        ];

        $decoded = json_decode($response, true);

        if ($httpCode >= 400) {
            $errorMessage = is_array($decoded) ? json_encode($decoded) : $response;
            throw new HSException("API Error ({$httpCode}): {$errorMessage}", $httpCode);
        }
        if(!empty($decoded) && !is_array($decoded)) {
            $decoded = [
                'message' => $decoded
            ];
        }
        return $decoded ?? [];
    }

    /**
     * Get last HTTP response details
     *
     * @return array Last response data
     */
    public function getLastResponse(): array
    {
        return $this->lastResponse;
    }
}
