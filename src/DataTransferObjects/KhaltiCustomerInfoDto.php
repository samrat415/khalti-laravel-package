<?php
namespace Khalti\KhaltiLaravel\DataTransferObjects;
class KhaltiCustomerInfoDto{

    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
    )
    {}

    public static function  fromRequest(\Illuminate\Http\Request $request)
    {
        return new self(
            name: $request->input('name','John Doe'),
            email: $request->input('email','sample@example.com') ,
            phone: $request->input('phone','+977 9800000000') ,
        );
    }
}
