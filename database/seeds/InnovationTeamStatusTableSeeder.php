<?php

use Illuminate\Database\Seeder;

class InnovationTeamStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $innovation_team_status = array(
            array('innovation_id' => '1', 'team_status_id' => '1'),
            array('innovation_id' => '1', 'team_status_id' => '2'),
            array('innovation_id' => '1', 'team_status_id' => '3'),
            array('innovation_id' => '1', 'team_status_id' => '4'),
            array('innovation_id' => '1', 'team_status_id' => '5'),
            array('innovation_id' => '2', 'team_status_id' => '1'),
            array('innovation_id' => '2', 'team_status_id' => '2'),
            array('innovation_id' => '2', 'team_status_id' => '3'),
            array('innovation_id' => '2', 'team_status_id' => '4'),
            array('innovation_id' => '2', 'team_status_id' => '5'),
            array('innovation_id' => '2', 'team_status_id' => '6'),
            array('innovation_id' => '2', 'team_status_id' => '7'),
            array('innovation_id' => '2', 'team_status_id' => '8'),
            array('innovation_id' => '2', 'team_status_id' => '9'),
            array('innovation_id' => '2', 'team_status_id' => '10'),
            array('innovation_id' => '2', 'team_status_id' => '11'),
            array('innovation_id' => '3', 'team_status_id' => '1'),
            array('innovation_id' => '3', 'team_status_id' => '2'),
            array('innovation_id' => '3', 'team_status_id' => '3'),
            array('innovation_id' => '3', 'team_status_id' => '4'),
            array('innovation_id' => '3', 'team_status_id' => '5'),
            array('innovation_id' => '3', 'team_status_id' => '6'),
            array('innovation_id' => '3', 'team_status_id' => '7'),
            array('innovation_id' => '3', 'team_status_id' => '8'),
            array('innovation_id' => '3', 'team_status_id' => '9'),
            array('innovation_id' => '3', 'team_status_id' => '10'),
            array('innovation_id' => '3', 'team_status_id' => '11')
        );

        if (is_array($innovation_team_status) && count($innovation_team_status)) {
            DB::table('innovation_team_status')->insert($innovation_team_status);
        }
    }
}
