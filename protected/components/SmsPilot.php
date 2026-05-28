<?php

class SmsPilot
{
    private const API_URL = 'https://smspilot.ru/api.php';

    private string $apiKey;
    private string $sender;

    public function __construct()
    {
        $params       = Yii::app()->params;
        $this->apiKey = $params['smsPilotApiKey'];
        $this->sender = $params['smsPilotSender'];
    }

    public function send(string $phone, string $message): bool
    {
        $phone = preg_replace('/\D/', '', $phone);

        $url = self::API_URL . '?' . http_build_query(array(
                'send'   => $message,
                'to'     => $phone,
                'from'   => $this->sender,
                'apikey' => $this->apiKey,
                'format' => 'json',
            ));

        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => true,
        ));

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            Yii::log("SmsPilot: curl error — $curlError. Phone: $phone", CLogger::LEVEL_ERROR, 'application');
            return false;
        }

        $data = json_decode($response, true);

        if (!empty($data['error'])) {
            Yii::log(
                "SmsPilot error #{$data['error']['code']}: {$data['error']['description_ru']}. Phone: $phone",
                CLogger::LEVEL_ERROR,
                'application'
            );
            return false;
        }

        Yii::log("SmsPilot: SMS отправлено на $phone", CLogger::LEVEL_INFO, 'application');
        return true;
    }
}
