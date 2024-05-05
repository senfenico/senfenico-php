<?php
namespace Senfenico;
require_once(__DIR__ . '/util.php');

class Charge {
    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function create($amount, $phone = null, $provider = null, $currency = "XOF", $paymentMethod = "mobile_money") {
        $url = "https://api.senfenico.com/v1/payment/charges/";
        $payload = [
            "amount" => $amount,
            "currency" => $currency,
            "payment_method" => $paymentMethod,
            "payment_method_details" => [
                "phone" => $phone,
                "provider" => $provider
            ]
        ];

        $response = makeRequest($this->apiKey, $url, "POST", $payload);
        return new SenfenicoJSON($response);
    }

    public function submitOtp($otp, $chargeReference) {
        $url = "https://api.senfenico.com/v1/payment/charges/submit";
        $payload = [
            "otp" => $otp,
            "charge_reference" => $chargeReference
        ];

        $response = makeRequest($this->apiKey, $url, "POST", $payload);
        return new SenfenicoJSON($response);
    }

    public function fetch($chargeReference) {
        $url = "https://api.senfenico.com/v1/payment/charges/$chargeReference";
        $response = makeRequest($this->apiKey, $url, "GET");
        return new SenfenicoJSON($response);
    }

    public function list() {
        $url = "https://api.senfenico.com/v1/payment/charges";
        $response = makeRequest($this->apiKey, $url, "GET");
        return new SenfenicoJSON($response);
    }

}