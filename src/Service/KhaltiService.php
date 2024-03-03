<?php

namespace Khalti\KhaltiLaravel\Service;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client as Guzzle;
use Khalti\KhaltiLaravel\DataTransferObjects\KhaltiCustomerInfoDto;
use Khalti\KhaltiLaravel\DataTransferObjects\KhaltiDto;

class KhaltiService
{
    public function __construct(

    )
    {
        $config = config('khalti-laravel.providers.khalti.'.config('khalti-laravel.env'));
       $this->ePaymentInitiateUrl =$config['ePayment_initiate_url'];
       $this->paymentValidationUrl  = $config['ePayment_initiate_url'];
       $this->returnUrl = $config['ePayment_initiate_url'];
       $this->websiteUrl = $config['ePayment_initiate_url'];
       $this->authToken = $config['LIVE_SECRET_KEY'];
    }

    public function ePaymentGenerateRequest(KhaltiDto $dto, KhaltiCustomerInfoDto $customerInfoDto )
    {
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
