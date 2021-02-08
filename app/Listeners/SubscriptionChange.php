<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SubscriptionChange
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        \Log::info("Subscription ". $event->subscription->status.' event triggered');
        $url = $event->subscription->device->app->callback_url; //third-party endpoint url which is already set in database
        $appId = $event->subscription->device->app->apple_id?$event->subscription->device->app->apple_id:$event->subscription->device->app->google_id;
        $deviceId = $event->subscription->device->uid;
        $params = ['AppID' =>$appId, 'deviceID'=> $deviceId];
        \Log::info(print_r(['URL'=>$url,'params'=>$params], true));

        //sending post request to third-party endpoint
        Http::withHeaders([
            'username'=>$event->subscription->device->app->username,
            'password'=>md5($event->subscription->device->app->password),
            ])
            ->post($url, $params);
    }
}
