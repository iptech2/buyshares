<?php
function getAccessToken() {
    $consumerKey = 'YourConsumerKey'; // Replace with your M-Pesa Consumer Key
    $consumerSecret = 'YourConsumerSecret'; // Replace with your M-Pesa Consumer Secret

    $credentials = base64_encode($consumerKey . ':' . $consumerSecret);
    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($curl);
    $result = json_decode($response);

    curl_close($curl);

    return $result->access_token;
}

function stkPushRequest($phoneNumber, $amount) {
    $accessToken = getAccessToken();
    $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $accessToken));
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $businessShortCode = '174379';
    $lipaNaMpesaOnlinePasskey = 'YourPasskey'; // Replace with your passkey
    $timestamp = date('YmdHis');
    $password = base64_encode($businessShortCode . $lipaNaMpesaOnlinePasskey . $timestamp);

    $curl_post_data = array(
        'BusinessShortCode' => $businessShortCode,
        'Password' => $password,
        'Timestamp' => $timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $amount,
        'PartyA' => $phoneNumber,
        'PartyB' => $businessShortCode,
        'PhoneNumber' => $phoneNumber,
        'CallBackURL' => 'http://yourcallbackurl.com/callback', // Replace with your callback URL
        'AccountReference' => 'Buy Share Investment',
        'TransactionDesc' => 'Buy Share Deposit'
    );

    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response);
}
?>
