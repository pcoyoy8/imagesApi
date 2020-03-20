<?php

use Illuminate\Database\Seeder;
use App\Image;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10 ; $i++)
        {
            Image::create([
                'picture_title' => $faker->streetName,
                'picture_url' => $faker->url,
                'picture_description' => $faker->macAddress
            ]);
        }
    }
}
