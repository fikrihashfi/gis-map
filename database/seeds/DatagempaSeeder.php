<?php

use Illuminate\Database\Seeder;

class DatagempaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //example data
        DB::table('gis_maps')->insert([
            'Lintang' => '-0.22',
            'Bujur' => '124.4745',
            'Kedalaman' => '10',
            'Magnitude' => '4.88',
            'Audio_Link' => '/audio/gempa_google_2.mp3',
            'Video_Link' => 'https://www.youtube.com/embed/jwnrt3oos2w'
        ]);
    }
}
