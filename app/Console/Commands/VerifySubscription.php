<?php

namespace App\Console\Commands;

use App\Events\SubscriptionCanceled;
use Illuminate\Console\Command;
use App\Models\Subscription;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use mysql_xdevapi\Exception;


class VerifySubscription extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command use to verify the subscriptions of applications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info(PHP_EOL."<<<<<<<<<<<<<<<<<<<<<<<  Verify Subscription Command: Started >>>>>>>>>>>>>>>>>>>>>>>>>>");
        $date = $this->getDateToday();
        $url = '';
        $subscriptions = Subscription::where([
            ['expiry_date', '<', $date],
            ['status', '!=', 'CANCELED'],
        ])
            ->with('device') //Eager loading for optimization.
            ->get();
        foreach ($subscriptions as $subscription) {
            if (!$subscription->receipt_id) {
                continue;
            }
            if ($subscription->device->os == \Config::get('values.os_google')) {
                $url = \Config::get('values.verify_subs_google');
            }
            if ($subscription->device->os == \Config::get('values.os_apple')) {
                $url = \Config::get('values.verify_subs_ios');
            }
            ## As required in document the last digit in the receipt value can be divided by 6 will generate a and rate limit error and require one more try.
            ## Additionally we are sending a flag so that in second try the response will be true;
            $retry = 1;
            while ($retry > 0) {
                try {
                    $this->verify($subscription, $url);
                    break;
                } catch (ThrottleRequestsException $e) {
                    $retry = $retry - 1;
                } catch (\Exception $e) {
                    break;
                }
            }

        }
        $this->info(PHP_EOL."<<<<<<<<<<<<<<<<<<<<<<<  Verify Subscription Command: Ended  >>>>>>>>>>>>>>>>>>>>>>>>>>>");
    }

    protected function verify($subscription, $url)
    {
        define(RATE_LIMIT_ERROR_CODE, 499);
        $response = Http::withHeaders([
            'username' => $subscription->device->app->username,
            'password' => md5($subscription->device->app->password),
        ])
            ->get($url, [
                    'receipt_id' => $subscription->receipt_id,
                ]
            );
        $success = \Arr::get($response, 'success');
        $error = \Arr::get($response, 'error');
        $status = \Arr::get($response, 'status');
        $rateLimitError = \Cong::get('values.max_rate_limit_error_code');
        if (!$success) {
            if ($error == $rateLimitError) {
                Log::error('Rate limit error for receipt id '.$subscription->receipt_id);
                throw new ThrottleRequestsException($error);
            }
        }
        $subscription->status = $status;
        $subscription->expiry_date = $this->getDateToday();
        $subscription->save();
        SubscriptionCanceled::dispatch($subscription);
        return true;
    }

    protected function getDateToday(): string
    {
        $date = new \DateTime("now", new \DateTimeZone("UTC"));
        $date = $date->format('Y-m-d');
        return $date;
    }
}
