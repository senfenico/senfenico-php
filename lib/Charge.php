<?php
namespace Senfenico;

require_once(__DIR__ . '/util.php');

class Charge {
    private $apiKey;

    public function __construct(string $apiKey) {
        if (empty($apiKey)) {
            throw new \InvalidArgumentException('API key cannot be empty');
        }
        $this->apiKey = $apiKey;
    }

    public function create(array $params) {
        $url = "https://api.senfenico.com/v1/payment/charges/";
        $payload = [
            'amount' => $params['amount'],
            'currency' => $params['currency'] ?? "XOF",
            'payment_method' => $params['payment_method'] ?? "mobile_money",
            'payment_method_details' => [
                'phone' => $params['phone'],
                'provider' => $params['provider']
            ]
        ];

        try {
            $response = makeRequest($this->apiKey, $url, "POST", $payload);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to create charge', 0, $e);
        }
    }

    public function submitOtp(array $params) {
        $url = "https://api.senfenico.com/v1/payment/charges/submit";
        $payload = [
            'otp' => $params['otp'],
            'charge_reference' => $params['charge_reference']
        ];

        try {
            $response = makeRequest($this->apiKey, $url, "POST", $payload);
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to submit OTP', 0, $e);
        }
    }

    public function fetch(string $reference, array $params = []) {
        if (empty($reference)) {
            throw new \InvalidArgumentException('Reference cannot be empty');
        }
        $url = "https://api.senfenico.com/v1/payment/charges/$reference";
        try {
            $response = makeRequest($this->apiKey, $url, "GET");
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to fetch charge', 0, $e);
        }
    }

    public function list(array $params = []) {
        $url = "https://api.senfenico.com/v1/payment/charges";
        try {
            $response = makeRequest($this->apiKey, $url, "GET");
            return new SenfenicoJSON($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to list charges', 0, $e);
        }
    }
}
