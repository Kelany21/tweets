<?php

/**
 * @param $customer
 * @param $phone
 * @param $carts
 * @param $totalPrice
 * @param $callBackUrl
 * @param $errorUrl
 * @param $data
 * @param null $reference
 * @param string $language
 * @return array
 */
function myfatoorahPaymentLink($customer, $phone, $carts, $totalPrice, $callBackUrl, $errorUrl, $data, $reference = null,
                               $language = 'en')
{
    $paymentMethodMap = [
        'visa' => '2',
        'mada' => '6',
        'apple' => '11',
    ];
    if (isset($paymentMethodMap[$data['payment_method']])) {
        if ($reference == null) {
            $reference = \Carbon\Carbon::now()->toDateString();
        }
        $mode = env("MYFATOORAH_MODE");
        $token = $mode == 'test' ? env("MYFATOORAH_TEST_TOKEN") : env("MYFATOORAH_TOKEN"); #token value to be placed here;
        $basURL = $mode == 'test' ? 'https://apitest.myfatoorah.com' : "https://api.myfatoorah.com";

        $curl = curl_init();

        $invoiceItems = [];

        $shipmentPercent = 0;
        $itemCount = 0;
        if ($data['total_shipping_price'] != 0) {
            foreach ($carts as $cart) {
                $itemCount += $cart->quantity;
            }
            $shipmentPercent = (float)$data['total_shipping_price'] / (float)$itemCount;
        }

        foreach ($carts as $cart) {
            $invoiceItems[] = [
                "ItemName" => $cart->product->name,
                "Quantity" => $cart->quantity,
                "UnitPrice" => $cart->price + $shipmentPercent
            ];
        }

        $body = [
            "PaymentMethodId" => $paymentMethodMap[$data['payment_method']],
            "CustomerName" => $customer['name'],
            "DisplayCurrencyIso" => "SAR",
            "MobileCountryCode" => "+966",
            "CustomerMobile" => $phone,
            "CustomerEmail" => $customer['email'],
            "InvoiceValue" => $totalPrice,
            "CallBackUrl" => $callBackUrl,
            "ErrorUrl" => $errorUrl,
            "Language" => $language,
            "CustomerReference" => $reference,
            "CustomerCivilId" => $customer['id'],
            "ExpireDate" => "",
            "CustomerAddress" => [
                "Block" => "",
                "Street" => "",
                "HouseBuildingNo" => "",
                "Address" => "",
                "AddressInstructions" => ""
            ],
            "InvoiceItems" => $invoiceItems,
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$basURL/v2/ExecutePayment",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $token", "Content-Type: application/json"),
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $log = [
                'api' => "$basURL/v2/ExecutePayment",
                'body' => $body,
                'err' => $err
            ];

            \App\Models\Log::create([
                'module' => 'payment',
                'action' => 'get-payment-link',
                'user_id' => auth()->check() ? auth()->id() : 0,
                'username' => auth()->check() ? auth()->user()->name : '',
                'new' => json_encode($log)
            ]);
            return ['done' => false, 'data' => $err];
        }

        $json = json_decode((string)$response, true);

        $log = [
            'api' => "$basURL/v2/ExecutePayment",
            'body' => $body,
            'response' => $json
        ];

        \App\Models\Log::create([
            'module' => 'payment',
            'action' => 'get-payment-link',
            'user_id' => auth()->check() ? auth()->id() : 0,
            'username' => auth()->check() ? auth()->user()->name : '',
            'new' => json_encode($log)
        ]);

        if (isset($json['Data']['PaymentURL'])) {
            return ['done' => true, 'data' => $json['Data']];
        }
        return ['done' => false, 'data' => $json];
    }
    return ['done' => false];
}

/**
 * @param $paymentId
 * @return false|mixed
 */
function myfatoorahGetInvoiceId($paymentId)
{
    $mode = env("MYFATOORAH_MODE");
    $token = $mode == 'test' ? env("MYFATOORAH_TEST_TOKEN") : env("MYFATOORAH_TOKEN"); #token value to be placed here;
    $basURL = $mode == 'test' ? 'https://apitest.myfatoorah.com' : "https://api.myfatoorah.com";
    $url = "$basURL/v2/getPaymentStatus";

    $data = array(
        'KeyType' => 'paymentId',
        'Key' => "$paymentId" //the callback paymentID
    );
    $fields = json_encode($data);

//####### Call API ######
    $curl = curl_init($url);

    curl_setopt_array($curl, array(
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $fields,
        CURLOPT_HTTPHEADER => array("Authorization: Bearer $token", 'Content-Type: application/json'),
        CURLOPT_RETURNTRANSFER => true,
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $log = [
            'api' => $url,
            'body' => $data,
            'err' => $err
        ];

        \App\Models\Log::create([
            'module' => 'payment',
            'action' => 'payment-status',
            'user_id' => auth()->check() ? auth()->id() : 0,
            'username' => auth()->check() ? auth()->user()->name : '',
            'new' => json_encode($log)
        ]);
        return false;
    }

    $json = json_decode((string)$response, true);



    $log = [
        'api' => $url,
        'body' => $data,
        'response' => $json
    ];

    \App\Models\Log::create([
        'module' => 'payment',
        'action' => 'payment-status',
        'user_id' => auth()->check() ? auth()->id() : 0,
        'username' => auth()->check() ? auth()->user()->name : '',
        'new' => json_encode($log)
    ]);

    if (isset($json['IsSuccess']) && isset($json['Data']['InvoiceStatus'])) {
        if ($json['IsSuccess'] && $json['Data']['InvoiceStatus'] == 'Paid'){
            return ['done' => true, 'data'=> $json['Data']['InvoiceId']];
        }
    }

    return false;
}

/**
 * @param $invoiceId
 * @return false|mixed
 */
function myfatoorahGetInvoiceDetails($invoiceId)
{
    $mode = env("MYFATOORAH_MODE");
    $token = $mode == 'test' ? env("MYFATOORAH_TEST_TOKEN") : env("MYFATOORAH_TOKEN"); #token value to be placed here;
    $basURL = $mode == 'test' ? 'https://apitest.myfatoorah.com' : "https://api.myfatoorah.com";
    $url = "$basURL/v2/getPaymentStatus";

    $data = array(
        'KeyType' => 'InvoiceId',
        'Key' => "$invoiceId" //the callback paymentID
    );
    $fields = json_encode($data);

//####### Call API ######
    $curl = curl_init($url);

    curl_setopt_array($curl, array(
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $fields,
        CURLOPT_HTTPHEADER => array("Authorization: Bearer $token", 'Content-Type: application/json'),
        CURLOPT_RETURNTRANSFER => true,
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $log = [
            'api' => $url,
            'body' => $data,
            'err' => $err
        ];

        \App\Models\Log::create([
            'module' => 'payment',
            'action' => 'invoice-details',
            'user_id' => auth()->check() ? auth()->id() : 0,
            'username' => auth()->check() ? auth()->user()->name : '',
            'new' => json_encode($log)
        ]);
        return ['done' => false, 'data'=> $err];
    }

    $json = json_decode((string)$response, true);



    $log = [
        'api' => $url,
        'body' => $data,
        'response' => $json
    ];

    \App\Models\Log::create([
        'module' => 'payment',
        'action' => 'invoice-details',
        'user_id' => auth()->check() ? auth()->id() : 0,
        'username' => auth()->check() ? auth()->user()->name : '',
        'new' => json_encode($log)
    ]);

    if (isset($json['IsSuccess'])) {
        if ($json['IsSuccess']){
            return ['done' => true, 'data'=> $json];
        }
    }

    return ['done' => false, 'data'=> $json];
}
