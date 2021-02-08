<?php

namespace App\Http\Controllers;

use App\Events\SubscriptionStarted;
use App\Events\SubscriptionRenewed;
use App\Models\Application;
use App\Models\Device;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use PhpParser\Builder;

class MobileApplicationSubscriptionController extends Controller {
    //
    /**
     * Register a device.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        //validation
        $this->validateRegReq();
        $uid = request('uId');
        $appId = request('app_id');
        $language = request('language');

        //Existing Check
        $device = Device::where([
            'uid'    => $uid,
            'app_id' => $appId
        ])
            ->first();
        if (!$device) {
            $device = new Device;
        }
        //Get App
        $app = Application::find($appId);

        //registering device
        $device->uid = $uid;
        $device->app_id = $app->id;
        $device->language = $language;
        $device->os = $app->apple_id ? \Config::get('values.os_apple') : \Config::get('values.os_google');
        $token = bin2hex(random_bytes(64)); // Token generation
        $device->client_token = $token;
        $device->save();

        return response()->json([
            'register' => 'OK',
            'token'    => $token,
        ]);

    }

    /**
     * Handle a purchase.
     *
     * @return \Illuminate\Http\Client\Response
     */

    public function purchase()
    {
        //validation
        $this->validatePurReq();
        $clientToken = request('client_token');
        $receiptId = request('receipt_id');

        //Existing Check
        $device = Device::where('client_token', $clientToken)->first();
        $url = null;
        $response = null;
        if (!$device) {
            return response()->json(['error' => 'Not Found!'], 404);
        }

        ####### Receipt validation from mocking platforms ##########

        //Getting corresponding URL for receipt verification
        if ($device->os == \Config::get('values.os_google')) {
            $url = \Config::get('values.google');
        }
        if ($device->os == \Config::get('values.os_apple')) {
            $url = \Config::get('values.ios');
        }
        // Sending request to mocking platform
        $response = Http::withHeaders([
            'username' => $device->app->username,
            'password' => md5($device->app->password),
        ])
            ->get($url, [
                'receipt_id' => $receiptId
            ]);
        if (\Arr::get($response, 'success')) {
            try {
                $subscription = Subscription::where('device_id', $device->id)->first();
                $new = true;
                if (!$subscription) {
                    $subscription = new Subscription();
                    $subscription->device_id = $device->id;
                    $subscription->status = 'started';
                } else {
                    $new = false;
                    $subscription->status = 'renewed';

                }
                $data = \Arr::get($response, 'expire_date');

                $dateUtc = new \DateTime($data, new \DateTimeZone("UTC"));
                $dateUtc = $dateUtc->format('Y-m-d H:i:s');

                $subscription->expiry_date = $dateUtc;
                $subscription->receipt_id = $receiptId;
                $subscription->save();

                if ($new) {
                    SubscriptionStarted::dispatch($subscription);
                } else {
                    SubscriptionRenewed::dispatch($subscription);
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                throw new \Exception($e->getMessage());
            }

            return response()->json([
                'purchase' => 'OK',
                'token'    => $clientToken,
                'status'   => $subscription->status,
            ]);
        } else {
            return response()->json(['error' => 'Invalid Receipt!'], 406);

        }
        ####### End Receipt validation ##########

    }

    /**
     * Check the subscription status
     *
     * @return \Illuminate\Http\Response
     */

    public function checkSubscription()
    {
        //
        \request()->validate([
            'client_token' => 'required|string|max:255',
        ]);
        $clientToken = request('client_token');
        $subscription = Subscription::whereHas('device', function ($query) use ($clientToken) {
            $query->where('client_token', '=', $clientToken);
        })
            ->first();
        if (!$subscription) {
            return response()->json(['error' => 'Not Found!'], 404);
        }

        return response()->json([
            'subscription' => 'OK',
            'status'       => $subscription->status,
        ]);

    }

    protected function validateRegReq(): array
    {
        return \request()->validate([
            'uId'      => 'required|string|max:36',
            'app_id'   => 'required|numeric|digits_between:0,20|exists:applications,id',
            'language' => 'string',
        ]);
    }

    protected function validatePurReq(): array
    {
        return \request()->validate([
            'client_token' => 'required|string|max:255',
            'receipt_id'   => 'required|numeric|digits_between:0,20',
        ]);
    }
}
