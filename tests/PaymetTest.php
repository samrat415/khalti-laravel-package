<?php

namespace Khalti\KhaltiLaravel;

use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase;

class PaymetTest extends TestCase
{
    public function testEPaymentVerificationTest()
    {
        $requestData = [
            'pidx' => 'uqGBzgkoiVMAvw8abrxXtD',
            // Add other required fields here
        ];
        $request = new Request($requestData);
        $response = Khalti::ePaymentValidationRequest($request);
        // Assert that the array has the expected keys
        $response = $response->json();
        $this->assertArrayHasKey('pidx', $response);
        $this->assertArrayHasKey('total_amount', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('transaction_id', $response);
        $this->assertArrayHasKey('fee', $response);
        $this->assertArrayHasKey('refunded', $response);
    }
}
