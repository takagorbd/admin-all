<?php
// Telegram Bot Token ও Chat ID
$botToken = "YOUR_BOT_TOKEN";
$chatId = "YOUR_CHAT_ID";

// ইনপুট ভ্যালু নেওয়া
$issueType = $_POST['issueType'] ?? '';
$phone = $_POST['phone'] ?? '';
$caption = "Issue: $issueType\nPhone: $phone";

$url = "https://api.telegram.org/bot$botToken/sendMessage";

// যদি ফাইল থাকে (screenshot)
if (isset($_FILES['screenshot']) && $_FILES['screenshot']['size'] > 0) {
    $filePath = $_FILES['screenshot']['tmp_name'];
    $fileName = $_FILES['screenshot']['name'];

    $url = "https://api.telegram.org/bot$botToken/sendPhoto";

    $postFields = [
        'chat_id' => $chatId,
        'caption' => $caption,
        'photo' => new CURLFile($filePath, mime_content_type($filePath), $fileName)
    ];
} else {
    $postFields = [
        'chat_id' => $chatId,
        'text' => $caption
    ];
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
$response = curl_exec($ch);
curl_close($ch);

echo "success";
