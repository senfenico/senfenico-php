<?php
namespace Senfenico;
require_once(__DIR__ . '/util.php');

class Balance {
    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function fetch() {
        $url = "https://api.senfenico.com/v1/payment/balances";
        $response = makeRequest($this->apiKey, $url, "GET");
        return new SenfenicoJSON($response);
    }

}