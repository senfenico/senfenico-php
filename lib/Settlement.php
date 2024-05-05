<?php
namespace Senfenico;
require_once(__DIR__ . '/util.php');

class Settlement {
    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function create(int $amount) {
        $url = "https://api.senfenico.com/v1/payment/settlements/";
        $payload = [
            "amount" => $amount
        ];

        $response = makeRequest($this->apiKey, $url, "POST", $payload);
        return new SenfenicoJSON($response);
    }

    public function fetch(string $settlementReference) {
        $url = "https://api.senfenico.com/v1/payment/settlements/$settlementReference";
        $response = makeRequest($this->apiKey, $url, "GET");
        return new SenfenicoJSON($response);
    }

    public function list() {
        $url = "https://api.senfenico.com/v1/payment/settlements";
        $response = makeRequest($this->apiKey, $url, "GET");
        return new SenfenicoJSON($response);
    }

    public function cancel(string $settlementReference) {
        $url = "https://api.senfenico.com/v1/payment/settlements/$settlementReference/cancel/";
        $response = makeRequest($this->apiKey, $url, "GET");
        return new SenfenicoJSON($response);
    }

}