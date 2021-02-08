<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlatformController extends Controller {
    //

    public function google(): array
    {

        return $this->process(\Config::get('values.os_google'));
    }

    public function ios(): array
    {

        return $this->process(\Config::get('values.os_apple'));
    }

    public function verifySubscriptionIos():array
    {

        return $this->processSubsVerification();
    }

    public function verifySubscriptionGoogle() :array
    {
        return $this->processSubsVerification();
    }

    public function thirdPartyEndpoint(){

        Log::info('##################### Third Party End Point Hit ##################');
        Log::info(\request()->all());
        Log::info('##################### -------------------------- ##################');
    }

    protected function verificationReceipt($number): bool
    {
        $flag = true;

        //Getting last digit
        preg_match_all('/\d+/', $number, $numbers);
        $lastFullNum = end($numbers[0]);
        $lastDigit = substr($lastFullNum, - 1);
        if ($lastDigit % 2 == 0) {
            $flag = false;
        };
        return $flag;
    }
    protected function generateExpiry($os): string
    {
        $dateUtc = null;
        //Apple expiry date in UTC-6
        if ($os == \Config::get('values.os_apple')) {
            try {
                $dateUtc = new \DateTime("now", new \DateTimeZone("America/Chicago"));
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        } else { // Google expiry date
            $dateUtc = new \DateTime("now");
        }
        // adding one month to expiry
        $dateUtc->add(new \DateInterval('P30D'));
        $dateUtc = $dateUtc->format('Y-m-d H:i:s');

        return $dateUtc;
    }

    /**
     * @param $os
     * @return array
     */
    protected function process($os): array
    {
        #Checking the headers sent in request#################
//       $headers = collect(\request()->header())->transform(function ($item) {
//          return $item[0];
//        });
//        \Log::info(print_r($headers,true));

        #####################################
        $receiptId = \request('receipt_id');
        $flag = $this->verificationReceipt($receiptId);
        $data = [];
        $data['success'] = false;

        if ($flag) {
            $data['success'] = true;
            $data['expire_date'] = $this->generateExpiry($os);;
        }
        return $data;
    }

    /**
     * @return array
     */
    protected function processSubsVerification(): array
    {
        $receiptId = \request('receipt_id');
        $data = [];
        $data['success'] = true;
        $data['status'] = 'canceled';
        if (
        (fmod($receiptId, 6) == 0)) {
            $bol = rand(0, 1);
            if ($bol) {
                $data['success'] = false;
                $data['error'] = \Config::get('values.max_rate_limit_error_code');;
            }
        }
        return $data;
    }
}
