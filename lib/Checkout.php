<?php
namespace Senfenico;

require_once(__DIR__. '/util.php');

class Checkout {
    private $apiKey;

    public function __construct(string $apiKey) {
        if (empty($apiKey)) {
            throw new \InvalidArgumentException('API key cannot be empty');
        }
        $this->apiKey = $apiKey;
    }

    public function initialize(array $params) {
        $requiredParams = ['amount', 'success_url', 'cancel_url'];
        foreach ($requiredParams as $param) {
            if (!isset($params[$param])) {
                throw new \InvalidArgumentException("Missing required parameter: $param");
            }
        }
        $url = "https://api.senfenico.com/v1/payment/checkouts/initialize/";
        $payload = [
            'email' => $params['email']?? 'customer@senfenico.com',
            'amount' => $params['amount'],
            'success_url' => $params['success_url'],
            'cancel_url' => $params['cancel_url'],
        ];
        try {
            $response = makeRequest($this->apiKey, $url, 'POST', $payload);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to initialize checkout', 0, $e);
        }
    }

    public function fetch(string $ref, array $params = []) {
        if (empty($ref)) {
            throw new \InvalidArgumentException('Reference cannot be empty');
        }
        $url = "https://api.senfenico.com/v1/payment/checkouts/$ref";
        try {
            $response = makeRequest($this->apiKey, $url, 'GET', $params);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to fetch checkout $ref", 0, $e);
        }
    }

    public function list(array $params = []) {
        $url = "https://api.senfenico.com/v1/payment/checkouts";
        try {
            $response = makeRequest($this->apiKey, $url, 'GET', $params);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to list checkouts', 0, $e);
        }
    }
}
