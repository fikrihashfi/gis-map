<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FakedatagempaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create('id_ID');
 
    	for($i = 1; $i <= 50; $i++){
            DB::table('gis_maps')->insert([
                'Lintang' => $faker->randomFloat($nbMaxDecimals = NULL, $min = -0.5, $max = -3),
                'Bujur' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 100, $max = 133),
                'Kedalaman' => $faker->numberBetween(0,50),
                'Magnitude' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 15),
                'Audio_Link' => $faker->randomLetter,
                'Video_Link' => $faker->randomLetter
            ]);     
        }

    }
}
