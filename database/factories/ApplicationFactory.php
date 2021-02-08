<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $id = rand(22222222,6666666);
        $appleId = null;
        $googleId = null;
        if($id % 2 == 0){
            $appleId = $id;
        }
        else{
            $googleId = $id;
        }
        return [
            'name' => $this->faker->unique()->name,
            'apple_id' => $appleId,
            'google_id' => $googleId,
            'username' => $this->faker->userName,
            'password' => $this->faker->password(6,8),
            'callback_url' => \Config::get('values.third_party_endpoint'),
        ];
    }
}
