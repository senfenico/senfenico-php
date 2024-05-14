<?php
namespace Senfenico;
require_once(__DIR__ . '/util.php');
use Illuminate\Support\Facades\Log;

class Webhook {

    public static function constructEvent($payload, $webhook_hash, $webhook_key) {
        
        $computed_hash = hash('sha256', $payload . $webhook_key);

        if ($computed_hash != $webhook_hash) {
            throw new \Exception('Invalid webhook hash');
        }

        return new SenfenicoJSON(Webhook::decodeNestedJson($payload));
    }

    public static function decodeNestedJson($json){
        // Step 1: Decode the outer JSON string
        $decodedJson = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return 'Invalid JSON: ' . json_last_error_msg();
        }

        // Step 2: Access and decode the nested JSON string in the `data` field
        if (isset($decodedJson['data'])) {
            $nestedJson = json_decode($decodedJson['data'], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return 'Invalid nested JSON: ' . json_last_error_msg();
            }

            // Step 3: Replace the encoded nested JSON string with its decoded array
            $decodedJson['data'] = $nestedJson;
        }

        return json_encode($decodedJson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

}