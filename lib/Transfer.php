<?php
namespace Senfenico;
require_once(__DIR__ . '/util.php');

class Transfer {
    private $apiKey;

    public function __construct(string $apiKey) {
        if (empty($apiKey)) {
            throw new \InvalidArgumentException('API key cannot be empty');
        }
        $this->apiKey = $apiKey;
    }

    public function create(array $params) {
        $requiredParams = ['amount', 'recipient_phone', 'recipient_wallet'];
        foreach ($requiredParams as $param) {
            if (!isset($params[$param])) {
                throw new \InvalidArgumentException("Missing required parameter: $param");
            }
        }
        $url = "https://api.senfenico.com/v1/payment/transfers/";
        $payload = [
            'amount' => $params['amount'],
            'recipient_phone' => $params['recipient_phone'],
            'recipient_wallet' => $params['recipient_wallet'],
            'ext_id' => $params['ext_id'] ?? null, // Optional
        ];
        try {
            $response = makeRequest($this->apiKey, $url, 'POST', $payload);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to create transfer', 0, $e);
        }
    }

    public function bulkCreate(array $params) {
        if (!isset($params['transfers']) || !is_array($params['transfers'])) {
            throw new \InvalidArgumentException("Missing or invalid 'transfers' parameter");
        }

        $url = "https://api.senfenico.com/v1/payment/transfers/bulk/";
        $payload = ['transfers' => $params['transfers']];
        try {
            $response = makeRequest($this->apiKey, $url, 'POST', $payload);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to create bulk transfer', 0, $e);
        }
    }

    public function fetch(string $ref, array $params = []) {
        if (empty($ref)) {
            throw new \InvalidArgumentException('Transfer reference cannot be empty');
        }
        $url = "https://api.senfenico.com/v1/payment/transfers/$ref";
        try {
            $response = makeRequest($this->apiKey, $url, 'GET', $params);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to fetch transfer $ref", 0, $e);
        }
    }

    public function list(array $params = []) {
        $url = "https://api.senfenico.com/v1/payment/transfers";
        try {
            $response = makeRequest($this->apiKey, $url, 'GET', $params);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to list transfers', 0, $e);
        }
    }
}
