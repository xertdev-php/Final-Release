<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = file_get_contents("countries.json");
        $response = json_decode($response);

        if(!empty($response)){
            foreach ($response as $item) {
                \App\Model\Country::create(array(
                   "country_code"=>$item->abbreviation,
                   "name"=>$item->country,
                ));
            }
        }
    }
}
