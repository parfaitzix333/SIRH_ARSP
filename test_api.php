<?php

/**
 * test_api.php
 * Teste la communication PHP -> FastAPI
 */

$api_url = 'http://127.0.0.1:8001/recognize';

// Le chemin de l'image à tester
$image_path = __DIR__ . '/public/image/sephora.jpeg';

if (!file_exists($image_path)) {
    die("Image introuvable : $image_path\n");
}

echo "Envoi de l'image : $image_path\n";
echo "Vers l'API : $api_url\n\n";

// --- Appel HTTP ---
$ch = curl_init($api_url);

$mime = mime_content_type($image_path) ?: 'image/jpeg';

curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => [
        'file' => new CURLFile($image_path, $mime, basename($image_path)),
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_HTTPHEADER     => ['Accept: application/json'],
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);

curl_close($ch);

// --- Affichage ---
if ($curl_error) {
    echo "❌ Erreur cURL : $curl_error\n";
    exit(1);
}

echo "Code HTTP : $http_code\n\n";

$data = json_decode($response, true);

if ($data === null) {
    echo "Réponse brute :\n$response\n";
    exit(1);
}

echo "Réponse de FastAPI :\n";
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
