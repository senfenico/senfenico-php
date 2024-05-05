<?php
namespace Senfenico;

class Checkout {
    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function initialize($amount, $successUrl, $cancelUrl, $email = "customer@senfenico.com") {
        $url = "https://api.senfenico.com/v1/payment/checkouts/initialize/";
        $payload = [
            "email" => $email,
            "amount" => $amount,
            "success_url" => $successUrl,
            "cancel_url" => $cancelUrl,
        ];

        $response = makeRequest($this->apiKey, $url, "POST", $payload);
        return new SenfenicoJSON($response);
    }

    public function fetch($checkoutReference) {
        $url = "https://api.senfenico.com/v1/payment/checkouts/$checkoutReference";
        $response = makeRequest($this->apiKey, $url, "GET");
        return new SenfenicoJSON($response);
    }

    public function list() {
        $url = "https://api.senfenico.com/v1/payment/checkouts";
        $response = makeRequest($this->apiKey, $url, "GET");
        return new SenfenicoJSON($response);
    }

}