<?php

// config for Khalti/KhaltiLaravel
return [
    'providers'=>[
        'khalti' =>[
            'production'=>[
                'LIVE_SECRET_KEY' => 'bb365eb8cba64104951f3c7151f34a45',
                'public_key' => 'X',
                'return_url'=>'/khalti-verify',
                'end_point'=>'https://khalti.com/api/v2/',
                'ePayment_initiate_url'=>'https://khalti.com/api/v2/epayment/initiate/',
            ],
            'testing'=>[
                'LIVE_SECRET_KEY' => 'bb365eb8cba64104951f3c7151f34a45',
                'public_key' => 'test_public_key_3c0a9d79251f4d09904ba432d06879fb',
                'return_url'=>'https://a.khalti.com/api/v2/khalti-verify',
                'end_point'=>'https://a.khalti.com/api/v2/',
                'ePayment_initiate_url'=>'https://a.khalti.com/api/v2/epayment/initiate/',
            ]

        ]
    ],
    'env'=>env('APP_ENV','testing')
];
