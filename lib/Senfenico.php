<?php

class Senfenico {
    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function __get($name) {
        $className = ucfirst($name);
        if (class_exists($className)) {
            return new $className($this->apiKey);
        }
        throw new Exception("Invalid property: $name");
    }
}