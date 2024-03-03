<?php

namespace Khalti\KhaltiLaravel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Khalti\KhaltiLaravel\DataTransferObjects\KhaltiCustomerInfoDto;
use Khalti\KhaltiLaravel\DataTransferObjects\KhaltiDto;
use Khalti\KhaltiLaravel\Service\KhaltiService ;

class Khalti extends ServiceProvider
{
    private static $config;

    public function register()
    {
        // Load the configuration
        self::$config = $this->app['config']->get('khalti-laravel');

    }

    public static function ePaymentInitiateRequest(Request $request)
    {
        // Your validation logic
        $validation = Validator::make($request->all(), [
            'purchase_order_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validation->fails()) {
            $errors = implode(",", $validation->messages()->all());
            return response()->json(['success' => false, 'message' => $errors], 400);
        }
        $config = config('khalti-laravel');
        // Create DTOs
        $khaltiCustomerInfo = KhaltiCustomerInfoDto::fromRequest($request);
        $khaltiDto = KhaltiDto::fromRequest($request);
        // Generate payment request using KhaltiService
        return (new KhaltiService($config))
            ->ePaymentGenerateRequest($khaltiDto, $khaltiCustomerInfo);
    }

    public static function ePaymentValidationRequest(Request $request)
    {
        $config = config('khalti-laravel');
        // Validate payment using KhaltiService
        return (new KhaltiService($config))
            ->validateEPayment($request->input("pidx", "r4wSp74utdRV9G7XRJVcnY"), self::$config);
    }
}
