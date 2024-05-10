<?php
namespace Senfenico;

class SenfenicoJSON {
    private $data;

    public function __construct($json) {
        $this->data = json_decode($json, true);
    }

    public function __get($name) {
        $value = $this->data[$name] ?? null;
        if (is_array($value)) {
            if (array_values($value) === $value) {
                return array_map(function ($item) {
                    return new self(json_encode($item));
                }, $value);
            } else {
                $obj = new self(json_encode($value));
                $obj->data = $value;
                return $obj;
            }
        }
        return $value;
    }

    public function __toString() {
        if (is_array($this->data) || is_object($this->data)) {
            return json_encode($this->data);
        } else {
            return (string) $this->data;
        }
    }

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    public function jsonSerialize() {
        return $this->data;
    }
}


function makeRequest($apiKey, $url, $method, $data = null) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'X-API-KEY: ' . $apiKey
        ),
    ));        
    $response = curl_exec($curl);
    if ($response === false) {
        echo 'Curl error: ' . curl_error($curl);
    }
    
    curl_close($curl);

    return $response;
}