<?php

use App\DisasterThreat;
use Illuminate\Database\Seeder;

class DisasterThreatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $disaster_threats = array(
            array('id' => '1', 'slug' => 'gempa', 'name' => 'Gempa', 'created_at' => '2020-04-11 20:23:54', 'updated_at' => '2020-04-11 20:23:54'),
            array('id' => '2', 'slug' => 'gunung-meletus', 'name' => 'Gunung Meletus', 'created_at' => '2020-04-11 20:24:10', 'updated_at' => '2020-04-11 20:24:10'),
            array('id' => '3', 'slug' => 'banjir', 'name' => 'Banjir', 'created_at' => '2020-04-11 20:24:19', 'updated_at' => '2020-04-11 20:24:19'),
            array('id' => '4', 'slug' => 'angin-puting-beliung', 'name' => 'Angin Puting Beliung', 'created_at' => '2020-04-11 20:24:31', 'updated_at' => '2020-04-11 20:24:31'),
            array('id' => '5', 'slug' => 'tanah-longsor', 'name' => 'Tanah Longsor', 'created_at' => '2020-04-11 20:24:39', 'updated_at' => '2020-04-11 20:24:39'),
            array('id' => '6', 'slug' => 'kebakaran', 'name' => 'Kebakaran', 'created_at' => '2020-04-11 20:24:46', 'updated_at' => '2020-04-11 20:24:46')
        );

        if (is_array($disaster_threats) && count($disaster_threats)) {
            DisasterThreat::query()->insert($disaster_threats);
        }
    }
}
