<?php
return [

    'google' => env('GOOGLE_VERIFY_URL','http://teknasyon-php-challenge.loc/api/mock/google'),
    'ios' => env('APPLE_VERIFY_URL','http://teknasyon-php-challenge.loc/api/mock/ios'),
    'os_google' => env('GOOGLE','GOOGLE'),
    'os_apple' => env('iOS','iOS'),
    'verify_subs_ios' => env('APPLE_VERIFY_SUBS_URL','http://teknasyon-php-challenge.loc/api/mock/verify-subs-ios'),
    'verify_subs_google' => env('GOOGLE_VERIFY_SUBS_URL','http://teknasyon-php-challenge.loc/api/mock/verify-subs-google'),

    'third_party_endpoint' => env('THIRD_PARTY_ENDPOINT','http://teknasyon-php-challenge.loc/api/mock/third-party-endpoint'),


    'max_rate_limit' => env('MAX_RATE_LIMIT',1000),

    'max_rate_limit_error_code' => env('MAX_RATE_LIMIT_ERROR_CODE',429),
];
