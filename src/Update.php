<?php

namespace Telegram\Bot;

class TelegramBot extends Config {
    private string $mode;
    private int $offset = 0;

    public function __construct(string $mode = 'polling') {
        if (!in_array($mode, ['webhook', 'polling'])) {
            throw new \Exception("Rejim 'webhook' yoki 'polling' bo'lishi kerak.");
        }

        $this->mode = $mode;
    }

    private function request(string $method, array $params = [], string $httpMethod = 'POST'): ?array {
        $url = 'https://api.telegram.org/bot' . $this->getToken() . '/' . $method;

        $ch = curl_init();

        if ($httpMethod === 'GET') {
            $url .= '?' . http_build_query($params);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            error_log("Telegram API xatosi: $error");
            return null;
        }

        $result = json_decode($response, true);
        return $result;
    }

    public function getUpdates(int $timeout = 30): ?array {
        if ($this->mode === 'webhook') {
            $update = json_decode(file_get_contents('php://input'), true);
            if (!$update) {
                http_response_code(400);
                return null;
            }
            return $update;
        } else {
            $response = $this->request('getUpdates', [
                'timeout' => $timeout,
                'offset' => $this->offset,
                'limit' => 1,
            ], 'GET');

            if ($response && $response['ok'] && !empty($response['result'])) {
                $update = $response['result'][0];
                $this->offset = $update['update_id'] + 1;
                return $update;
            }

            return null;
        }
    }
}
