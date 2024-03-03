<?php

namespace Khalti\KhaltiLaravel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Khalti\KhaltiLaravel\DataTransferObjects\KhaltiCustomerInfoDto;
use Khalti\KhaltiLaravel\DataTransferObjects\KhaltiDto;
use Khalti\KhaltiLaravel\Service\KhaltiService ;

class Khalti
{
    public function __construct()
    {
        $this->khalti = new KhaltiService();
    }

    public function ePaymentInitiateRequest(Request $request )
    {
        $validation = Validator::make($request->all(), [
            'purchase_order_id' => 'required',
            'amount' => 'required | numeric ',
        ]);
        if ($validation->fails()) {
            $errors = implode(",", $validation->messages()->all());
            return response()->json(['success'=>false,'message'=>$errors], 400);
        }
        $khaltiCustomerInfo = KhaltiCustomerInfoDto::fromRequest($request);
        $khaltiDto = KhaltiDto::fromRequest($request);
        return (($this->khalti)->ePaymentGenerateRequest($khaltiDto,$khaltiCustomerInfo));
    }

    public function ePaymentValidationRequest(Request $request){
        return ($this->khalti)
            ->validateEPayment(
                $request->input("pidx","r4wSp74utdRV9G7XRJVcnY")
            );
    }

}
