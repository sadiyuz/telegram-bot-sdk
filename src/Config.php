<?php

namespace Telegram\Bot;

class Config {
    protected string $token;
    protected string $apiUrl = 'https://api.telegram.org';
    protected bool $debug = false;

    public function setToken($token) {
        $this->token = $token;
    }

    public function getToken() {
        return $this->token;
    }

    public function setApiUrl($url) {
        $this->apiUrl = $url;
    }

    public function getApiUrl() {
        return $this->apiUrl;
    }

    public function setDebug($debug) {
        $this->debug = $debug;
    }

    public function isDebug() {
        return $this->debug;
    }

}