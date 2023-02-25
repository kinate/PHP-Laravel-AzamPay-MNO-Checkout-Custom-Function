<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AzamPay extends Controller
{
     function getAccessToken(){ // Get access token
        $response = Http::post(
            env('AZAMPAY_BASE_PATH')."/AppRegistration/GenerateToken", [
                "appName"=> env('AZAMPAY_APPNAME'),
                "clientId"=> env('AZAMPAY_CLIENT_ID'),
                "clientSecret"=> env('AZAMPAY_CLIENT_SECRET')
                  ]);
       return $response['data']['accessToken'];
       
    }
    public function AzamPayRequest(Request $request){ // Make payment
    $accessToken = AzamPay::getAccessToken();  
    $data = [
        "accountNumber"=> "0713807919",
        "additionalProperties"=> [
          "property1"=> null,
          "property2"=> null
        ],
        "amount"=> "1000",
        "currency"=> "tzs",
        "externalId"=> "string",
        "provider"=> "Tigo"
    ];
    $paymentResponse = Http::withToken($accessToken)->post(
        env('AZAMPAY_MNO_CHECKOUT_PATH')."/azampay/mno/checkout", $data
    );
    dd($paymentResponse->json());

}
}