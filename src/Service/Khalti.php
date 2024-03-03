<?php

namespace SamratThapa\SamratKhalti\Service;
use Illuminate\Support\Facades\Http;
use SamratThapa\SamratKhalti\DataTransferObjects\KhaltiCustomerInfoDto;
use SamratThapa\SamratKhalti\DataTransferObjects\KhaltiDto;
use GuzzleHttp\Client as Guzzle;

class Khalti
{
    public function __construct(
       $config
    )
    {
       $this->ePaymentInitiateUrl =$config['ePayment_initiate_url'];
       $this->paymentValidationUrl  = $config['ePayment_initiate_url'];
       $this->returnUrl = $config['ePayment_initiate_url'];
       $this->websiteUrl = $config['ePayment_initiate_url'];
       $this->authToken = $config['LIVE_SECRET_KEY'];
    }

    public function ePaymentGenerateRequest(KhaltiDto $dto, KhaltiCustomerInfoDto $customerInfoDto )
    {
        $client = new Guzzle(['base_uri' => 'https://a.khalti.com/api/v2/']);
//        $response = $client->request('POST', "epayment/initiate/", [
//            'headers' =>[
//                "Authorization" => "Key bb365eb8cba64104951f3c7151f34a45",
//                'Content-Type' => 'application/json'
//            ],
//            'form_params' => [
//                'return_url'=>$this->returnUrl,
//                'website_url'=>$this->websiteUrl,
//                'amount'=>$dto->amount,
//                'purchase_order_id'=>$dto->purchaseOrderId,
//                'purchase_order_name'=>$dto->purchaseOrderName,
//            ]
//        ]);
        $response = Http::withHeaders([
            "Authorization" => "Key {$this->authToken}",
            'Content-Type' => 'application/json'
        ])->post("$this->ePaymentInitiateUrl",[
            'return_url'=>$this->returnUrl,
            'website_url'=>$this->websiteUrl,
            'amount'=>$dto->amount,
            'purchase_order_id'=>$dto->purchaseOrderId,
            'purchase_order_name'=>$dto->purchaseOrderName,
        ]);
        return $response;
    }

    public function validateEPayment(string $pidx){
        $response = Http::withHeaders([
            "Authorization" => "Key {$this->authToken}",
            'Content-Type' => 'application/json'
        ])->post("https://a.khalti.com/api/v2/epayment/lookup/",[
            'pidx'=>$pidx,
        ]);
        return $response;
    }

}
