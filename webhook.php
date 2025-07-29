<?php
file_put_contents('debug.txt', date('Y-m-d H:i:s') . " - Received: " . file_get_contents('php://input') . "\n", FILE_APPEND);

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['tags']) && in_array('جدید برای ارسال به واحد اجرایی', $input['tags'])) {
    $text = "📎 فایل جدید با این تگ آپلود شد:\n\n";
    $text .= "📁 " . ($input['path'] ?? '[مسیر نامشخص]');

    $chat_id = "-1002748666643";
    $bot_token = "8017615588:AAGb7hJFVcNeh2TKFo-Hjmex-geiWSMqmeI";

    $url = "https://api.telegram.org/bot$bot_token/sendMessage";
    $payload = json_encode([
        "chat_id" => $chat_id,
        "text" => $text
    ]);

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/json",
            'content' => $payload
        ]
    ];
    $result = file_get_contents($url, false, stream_context_create($options));
    file_put_contents('debug.txt', date('Y-m-d H:i:s') . " - Telegram response: " . $result . "\n", FILE_APPEND);
} else {
    file_put_contents('debug.txt', date('Y-m-d H:i:s') . " - No matching tag found\n", FILE_APPEND);
}

echo "Webhook OK";
