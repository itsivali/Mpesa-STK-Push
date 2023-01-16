<?php
    // define the parameters for the request
    $BusinessShortCode = "123456"; // the shortcode of your business
    $LipaNaMpesaPasskey = "YOUR_PASSKEY";
    $TransactionType = "CustomerPayBillOnline";
    $Amount = "1000"; // the amount of the transaction
    $PartyA = "254702524433"; // the phone number of the customer
    $PartyB = "123456"; // your shortcode
    $PhoneNumber = "254702524433"; // the phone number of the customer
    $CallBackURL = "https://yourwebsite.com/callback"; // the URL to which M-PESA will send a confirmation of the transaction
    $AccountReference = "YOUR_REFERENCE"; // a reference for the transaction
    $TransactionDesc = "Testing STK Push"; // a description of the transaction

    // generate the timestamp for the request
    $Timestamp = date('YmdHis');

    // generate the password for the request
    $Password = base64_encode($BusinessShortCode . $LipaNaMpesaPasskey . $Timestamp);

    // create the request payload
    $data = array(
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => $TransactionType,
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $PartyB,
        'PhoneNumber' => $PhoneNumber,
        'CallBackURL' => $CallBackURL,
        'AccountReference' => $AccountReference,
        'TransactionDesc' => $TransactionDesc
    );

    // send the request to the M-PESA API endpoint
    $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    // process the response
    if ($status == 200) {
        // the request was successful
        $result = json_decode($response);
        echo "Transaction ID: " . $result->MerchantRequestID . "<br>";
        echo "Checkout Request ID: " . $result->CheckoutRequestID . "<br>";
        echo "Response Code: " . $result->ResponseCode . "<br>";
        echo "Response Description: " . $result->ResponseDescription . "<br>";
    }
     else 
     {
        // an error occurred
        echo "Request failed.<br>";
        echo "Response Code: ". $status. "<br>";
     } 