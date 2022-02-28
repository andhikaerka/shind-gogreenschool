<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityTeamStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activity_team_status = array(
            array('activity_id' => '1', 'team_status_id' => '1'),
            array('activity_id' => '1', 'team_status_id' => '3'),
            array('activity_id' => '1', 'team_status_id' => '4'),
            array('activity_id' => '1', 'team_status_id' => '5'),
            array('activity_id' => '1', 'team_status_id' => '7'),
            array('activity_id' => '2', 'team_status_id' => '2'),
            array('activity_id' => '2', 'team_status_id' => '3'),
            array('activity_id' => '2', 'team_status_id' => '4'),
            array('activity_id' => '2', 'team_status_id' => '5'),
            array('activity_id' => '2', 'team_status_id' => '6'),
            array('activity_id' => '2', 'team_status_id' => '11'),
            array('activity_id' => '3', 'team_status_id' => '3'),
            array('activity_id' => '4', 'team_status_id' => '5'),
            array('activity_id' => '5', 'team_status_id' => '1'),
            array('activity_id' => '5', 'team_status_id' => '2'),
            array('activity_id' => '5', 'team_status_id' => '3'),
            array('activity_id' => '5', 'team_status_id' => '5'),
            array('activity_id' => '5', 'team_status_id' => '6'),
            array('activity_id' => '5', 'team_status_id' => '7'),
            array('activity_id' => '5', 'team_status_id' => '8'),
            array('activity_id' => '5', 'team_status_id' => '9'),
            array('activity_id' => '5', 'team_status_id' => '10'),
            array('activity_id' => '5', 'team_status_id' => '11'),
            array('activity_id' => '6', 'team_status_id' => '1'),
            array('activity_id' => '6', 'team_status_id' => '2'),
            array('activity_id' => '6', 'team_status_id' => '3'),
            array('activity_id' => '6', 'team_status_id' => '4'),
            array('activity_id' => '6', 'team_status_id' => '6'),
            array('activity_id' => '6', 'team_status_id' => '7'),
            array('activity_id' => '6', 'team_status_id' => '8'),
            array('activity_id' => '6', 'team_status_id' => '9'),
            array('activity_id' => '6', 'team_status_id' => '10'),
            array('activity_id' => '6', 'team_status_id' => '11')
        );

        if (is_array($activity_team_status) && count($activity_team_status)) {
            DB::table('activity_team_status')->insert($activity_team_status);
        }
    }
}
