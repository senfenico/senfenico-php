<?php
namespace Senfenico;
require_once(__DIR__ . '/util.php');


class Settlement {
    private $apiKey;

    public function __construct(string $apiKey) {
        if (empty($apiKey)) {
            throw new \InvalidArgumentException('API key cannot be empty');
        }
        $this->apiKey = $apiKey;
    }

    public function create(array $params) {
        $requiredParams = ['amount'];
        foreach ($requiredParams as $param) {
            if (!isset($params[$param])) {
                throw new \InvalidArgumentException("Missing required parameter: $param");
            }
        }
        $url = "https://api.senfenico.com/v1/payment/settlements/";
        $payload = [
            'amount' => $params['amount'],
        ];
        try {
            $response = makeRequest($this->apiKey, $url, 'POST', $payload);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to create settlement', 0, $e);
        }
    }

    public function fetch(string $ref, array $params = []) {
        if (empty($ref)) {
            throw new \InvalidArgumentException('Reference cannot be empty');
        }
        $url = "https://api.senfenico.com/v1/payment/settlements/$ref";
        try {
            $response = makeRequest($this->apiKey, $url, 'GET', $params);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to fetch settlement $ref", 0, $e);
        }
    }

    public function list(array $params = []) {
        $url = "https://api.senfenico.com/v1/payment/settlements";
        try {
            $response = makeRequest($this->apiKey, $url, 'GET', $params);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to list settlements', 0, $e);
        }
    }

    public function cancel(string $ref, array $params = []) {
        if (empty($ref)) {
            throw new \InvalidArgumentException('Reference cannot be empty');
        }
        $url = "https://api.senfenico.com/v1/payment/settlements/$ref/cancel/";
        try {
            $response = makeRequest($this->apiKey, $url, 'GET', $params);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to cancel settlement $ref", 0, $e);
        }
    }
}
