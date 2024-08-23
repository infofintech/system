<?php
$data = [
    'amount' => $_REQUEST['amount'],
    'orderId' => date('Y-m-d H:i:s'),
    'shopId' => '05d6662e-138a-4cdc-bd4b-bd20a41d49e0',
    'hookUrl' => null,
    'service' => 'card_payoff',
    'walletTo' => '2200240797076029',
    'subtract' => 0
];
$secretKey = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOiI3MmMyZGUwMS04ZWE1LWI3YWUtOWY5Zi1iNzgwYjY0OWU2YmUiLCJ0aWQiOiI0ZTQ0ZjFiZi0yMjI4LWRmOWUtZjA2Mi1lMTE4ZjI1NGMyZmUifQ.8QBDHFnMd_NUcMY6XtbixbeMk3NHZ3YhqrUmKAdnug4";
$data = json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
$signature = hash_hmac('sha256', $data, $secretKey);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.lava.ru/business/payoff/create', 
    CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 5,
    CURLOPT_FOLLOWLOCATION => true, 
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
    CURLOPT_CUSTOMREQUEST => 'POST', 
    CURLOPT_POSTFIELDS => $data, 
    CURLOPT_HTTPHEADER => array(
        'Accept: application/json', 'Content-Type: application/json', 'Signature: ' . $signature
        ), ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
