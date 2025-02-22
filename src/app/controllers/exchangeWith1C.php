<?php
$url = "https://uztest.kraft.net.ua:8443/smile-test-bor/hs/rts/products";
$data = ["username" => "test", "password" => "1234"];
$jsonData = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Content-Length: " . strlen($jsonData)
]);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
