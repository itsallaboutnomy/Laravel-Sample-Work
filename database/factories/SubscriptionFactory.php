<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;
    protected $sub = 0;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $collection = Device::all()->pluck('id')->toArray();
        $count = sizeof($collection);
        $this->sub = $this->sub + 1;
        return [
            'device_id' => $collection[$count - $this->sub],
            'status' => $this->faker->randomElement(['RENEWED','STARTED']),
            'receipt_id' => $this->faker->numberBetween(111111),
            'expiry_date' => $this->faker->dateTimeBetween('-2 months', '+2 months'),
        ];
    }
}
