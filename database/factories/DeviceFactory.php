<?php

namespace Database\Factories;

use App\Models\App;
use App\Models\Application;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;
//    protected $x = 0;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $collection = collect(\App\Models\Application::all());
        $idsCol = $collection->pluck('id','id');
        $iOSCol = $collection->pluck('apple_id','id');
        $googleCol = $collection->pluck('google_id','id');

        $idArray = $idsCol->toArray();
        $iOSArray = $iOSCol->toArray();
        $googleArray = $googleCol->toArray();

        $key =  array_rand($idArray);

        $appId = \Arr::get($idArray,$key);
        $os = null;
        if(\Arr::get($iOSArray,$key)){
            $os = 'iOS';
        };
        if(\Arr::get($googleArray,$key)){
            $os = 'GOOGLE';
        };

        return [
            'app_id' => $appId,
            'uid' => $this->faker->uuid,
            'client_token' => $this->faker->unique()->md5,
            'os' => $os,
            'language' => $this->faker->languageCode,
        ];

    }
}


/*randomElement([
    "56f1f683-2fe3-300d-a2ce-56e90ffe1f14",
    "c199ec64-95bd-3e38-b5d2-c0ccbd9c7805",
    "bfabfba1-44f1-3834-b382-20417be0b753",
    "f96fdf62-a233-3a4b-b923-cc617ab2ee5c",
    "86715b7b-5b3a-3a7c-b2ac-f39f2252bc94",
    "b1ae581d-3c02-38ee-baf3-f312adc03e99",
    "867d5128-733a-36f1-a9fb-f05094c20b80",
    "d0f2d56f-a319-3c83-9980-dc42c9236e6b",
    "2f220da7-322e-3850-9e11-fe7f210cf6f6",
    "9608ad91-d68b-32ba-9261-79f27bdc838c",
    "3765e3df-b3b6-3407-bfb5-a82f262d1ccc",
    "5855a458-b6ff-335c-9750-19ac0575b8ad",
    "ab379ce9-97c1-3ff6-82bd-b7ded7d8fe97",
    "8819c447-9cba-3d13-ac2b-194aba932d6f",
    "4a342baf-25e5-37a4-a68a-567f3e2ccc6e",
    "369b9703-79a6-3df5-a60c-7e6d90aff7eb",
    "08ace7f1-022b-34f8-b9e1-7f429389e4e0",
    "fe7de739-80db-3e2a-8aa3-db04bf82b516",
    "e0c05978-ae3c-3015-9354-c701fc47ac8b",
    "c5d156fb-eadb-3682-9be5-2c51cde92a1d",
    "c26ef6e6-e730-301a-89d7-31568e9de6a6",
    "1bfb13e2-37db-3ec5-b756-a1ef6132eef8",
    "49df12e2-b3d4-3559-a2d0-99c4461bb4f7",
    "a088fea2-9e63-37bc-9c1f-31f9db98bc73",
    "4d0f7b82-bea2-3283-a180-95bf188aa4f2",
    "79d84dbe-c523-3d50-8254-68473284f320",
    "bc7ebe43-8713-3f41-b95f-0b2c19e39b05",
    "25ffc44f-88e1-3259-a33c-45ab64645cb9",
    "c54a3ab0-5c52-3064-92ab-8f6a802b62bd",
    "3abbfb9d-406e-34e3-85bb-0142b164d3c8",
    "0b13ecce-9112-320c-b1e4-09e2348f26e1",
    "789f5d56-f7a8-3641-bb97-a15a856a743a",
    "7b95c916-524f-3a62-a229-95f7cef14fd5",
    "ce94f911-1e37-383e-aea0-342be1e9c6dd",
    "64a256e5-1779-37c4-a02d-3cbde9f9521b",
    "873fb755-eafe-3df4-af47-ac4defc4924a",
    "04c97097-6158-3c12-9e30-fc963f87309a",
    "c9bb6cc5-5e12-34f6-8ff6-0dd811c537c5",
    "b0a079f6-3acd-3dee-9f03-71ededfca1c7",
    "9a445d26-aa79-376c-9b5f-b211c99bb54c",
    "bd48c753-2262-32ec-bdd3-c365e7ccab12",
    "140d5ea4-ae76-3cbc-8872-e1f0eae6f091",
    "43590f47-7319-32ca-a8cc-5d72d0db8e3b",
    "9da268f7-9459-3098-9ca8-3dedcf2bd582",
    "ea09e08f-a423-373c-9bc4-ae10e98d7016",
    "2f98850b-bc7c-3d3c-ac57-1f363b41af89",
    "29206f42-c85c-3dc2-8ffd-06e9178cca55",
    "65d31ac5-b758-3fd5-b40b-38af9535bb7c",
    "871a1c06-2b0e-3a19-86ca-c3a9c5a7ef9b",
    "f8bd68d3-caab-3fe0-a5af-1845aa3ebbcc",
];
*/
