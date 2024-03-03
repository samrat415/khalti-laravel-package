<?php

namespace Khalti\KhaltiLaravel\Service;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Khalti\KhaltiLaravel\DataTransferObjects\KhaltiCustomerInfoDto;
use Khalti\KhaltiLaravel\DataTransferObjects\KhaltiDto;

class KhaltiService
{
    private $config;

    private mixed $ePaymentInitiateUrl;

    private string $paymentValidationUrl;

    private string $authToken;

    private string $returnUrl;

    private string $websiteUrl;

    public function __construct(array $config)
    {
        $this->config = $config;
        //        print_r($this->config);
        // Set your properties using the config array
        $this->ePaymentInitiateUrl = $this->config['ePayment_initiate_url'];
        $this->paymentValidationUrl = $this->config['payment_validation_url'];
        $this->authToken = $this->config['LIVE_SECRET_KEY'];
        $this->returnUrl = $this->config['return_url'];
        $this->websiteUrl = $this->config['website_url'];
        // Set other properties accordingly
    }

    public function ePaymentGenerateRequest(KhaltiDto $dto, KhaltiCustomerInfoDto $customerInfoDto)
    {
        $response = Http::withHeaders([
            'Authorization' => "Key {$this->authToken}",
            'Content-Type' => 'application/json',
        ])->post("$this->ePaymentInitiateUrl", [
            'return_url' => $this->returnUrl,
            'website_url' => $this->websiteUrl,
            'amount' => $dto->amount,
            'purchase_order_id' => $dto->purchaseOrderId,
            'purchase_order_name' => $dto->purchaseOrderName,
        ]);

        return $response;
    }

    public function validateEPayment(string $pidx)
    {
        $response = Http::withHeaders([
            'Authorization' => "Key {$this->authToken}",
            'Content-Type' => 'application/json',
        ])->post("{$this->paymentValidationUrl}", [
            'pidx' => $pidx,
        ]);

        return $response;
    }
}
