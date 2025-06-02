<?php

namespace Telegram\Bot;

class Bot extends Config
{
    public function getUpdates(array $params = [])
    {
        return $this->request('getUpdates', $params);
    }

    public function setWebhook(array $params)
    {
        return $this->request('setWebhook', $params);
    }

    public function deleteWebhook()
    {
        return $this->request('deleteWebhook');
    }

    public function sendMessage(array $params)
    {
        return $this->request('sendMessage', $params);
    }

    public function sendVideo(array $params)
    {
        return $this->request('sendVideo', $params);
    }
    
    public function sendPhoto(array $params)
    {
        return $this->request('sendPhoto', $params);
    }

    public function sendDocument(array $params)
    {
        return $this->request('sendDocument', $params);
    }

    public function sendAudio(array $params)
    {
        return $this->request('sendAudio', $params);
    }

    public function sendVoice(array $params)
    {
        return $this->request('sendVoice', $params);
    }

    public function sendLocation(array $params)
    {
        return $this->request('sendLocation', $params);
    }

    public function sendContact(array $params)
    {
        return $this->request('sendContact', $params);
    }

    public function sendPoll(array $params)
    {
        return $this->request('sendPoll', $params);
    }

    public function answerCallbackQuery(array $params)
    {
        return $this->request('answerCallbackQuery', $params);
    }

    public function editMessageText(array $params)
    {
        return $this->request('editMessageText', $params);
    }

    public function editMessageReplyMarkup(array $params)
    {
        return $this->request('editMessageReplyMarkup', $params);
    }

    public function editMessageCaption(array $params)
    {
        return $this->request('editMessageCaption', $params);
    }
    public function copyMessage(array $params)
    {
        return $this->request('copyMessage', $params);
    }
    public function forwardMessage(array $params)
    {
        return $this->request('forwardMessage', $params);
    }
    public function getMe()
    {
        return $this->request('getMe');
    }
    public function getFile(array $params)
    {
        return $this->request('getFile', $params);
    }
    public function kickChatMember(array $params)
    {
        return $this->request('kickChatMember', $params);
    }
    public function unbanChatMember(array $params)
    {
        return $this->request('unbanChatMember', $params);
    }
    public function restrictChatMember(array $params)
    {
        return $this->request('restrictChatMember', $params);
    }
    public function promoteChatMember(array $params)
    {
        return $this->request('promoteChatMember', $params);
    }
    public function setChatAdministratorCustomTitle(array $params)
    {
        return $this->request('setChatAdministratorCustomTitle', $params);
    }
    public function banChatSenderChat(array $params)
    {
        return $this->request('banChatSenderChat', $params);
    }
    public function unbanChatSenderChat(array $params)
    {
        return $this->request('unbanChatSenderChat', $params);
    }
    public function setChatPermissions(array $params)
    {
        return $this->request('setChatPermissions', $params);
    }
    public function getChat(array $params)
    {
        return $this->request('getChat', $params);
    }
    public function getChatAdministrators(array $params)
    {
        return $this->request('getChatAdministrators', $params);
    }
    public function getChatMember(array $params)
    {
        return $this->request('getChatMember', $params);
    }
    public function leaveChat(array $params)
    {
        return $this->request('leaveChat', $params);
    }
    public function answerInlineQuery(array $params)
    {
        return $this->request('answerInlineQuery', $params);
    }
    public function answerShippingQuery(array $params)
    {
        return $this->request('answerShippingQuery', $params);
    }
    public function answerPreCheckoutQuery(array $params)
    {
        return $this->request('answerPreCheckoutQuery', $params);
    }
    public function sendDice(array $params)
    {
        return $this->request('sendDice', $params);
    }

    public function request($method, $params = [])
    {
        $ch = curl_init();
        $url = $this->getApiUrl() . '/bot' . $this->getToken() . '/' . $method;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $response = curl_exec($ch);
        if ($this->isDebug()) {
            echo "Request URL: $url\n";
            echo "Response: $response\n";
        }
        curl_close($ch);
        $result = json_decode($response, true);
        if (isset($result['ok']) && $result['ok']) {
            return $result['result'];
        } else {
            throw new \Exception('Telegram API error: ' . ($result['description'] ?? 'Unknown error'));
        }
    }
}
