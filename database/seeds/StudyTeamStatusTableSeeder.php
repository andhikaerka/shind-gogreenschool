<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyTeamStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $study_team_status = array(
            array('study_id' => '1', 'team_status_id' => '1'),
            array('study_id' => '2', 'team_status_id' => '1'),
            array('study_id' => '2', 'team_status_id' => '2'),
            array('study_id' => '2', 'team_status_id' => '3'),
            array('study_id' => '2', 'team_status_id' => '4'),
            array('study_id' => '2', 'team_status_id' => '5'),
            array('study_id' => '2', 'team_status_id' => '6'),
            array('study_id' => '2', 'team_status_id' => '7'),
            array('study_id' => '2', 'team_status_id' => '8'),
            array('study_id' => '2', 'team_status_id' => '9'),
            array('study_id' => '2', 'team_status_id' => '10'),
            array('study_id' => '2', 'team_status_id' => '11'),
            array('study_id' => '3', 'team_status_id' => '1'),
            array('study_id' => '3', 'team_status_id' => '2'),
            array('study_id' => '4', 'team_status_id' => '1'),
            array('study_id' => '4', 'team_status_id' => '2'),
            array('study_id' => '4', 'team_status_id' => '3'),
            array('study_id' => '4', 'team_status_id' => '4'),
            array('study_id' => '4', 'team_status_id' => '5'),
            array('study_id' => '4', 'team_status_id' => '7'),
            array('study_id' => '4', 'team_status_id' => '9'),
            array('study_id' => '4', 'team_status_id' => '10'),
            array('study_id' => '4', 'team_status_id' => '11'),
            array('study_id' => '5', 'team_status_id' => '1'),
            array('study_id' => '5', 'team_status_id' => '2'),
            array('study_id' => '6', 'team_status_id' => '1'),
            array('study_id' => '6', 'team_status_id' => '2'),
            array('study_id' => '7', 'team_status_id' => '1'),
            array('study_id' => '7', 'team_status_id' => '2'),
            array('study_id' => '7', 'team_status_id' => '3'),
            array('study_id' => '7', 'team_status_id' => '4'),
            array('study_id' => '7', 'team_status_id' => '5'),
            array('study_id' => '7', 'team_status_id' => '6'),
            array('study_id' => '7', 'team_status_id' => '7'),
            array('study_id' => '7', 'team_status_id' => '8'),
            array('study_id' => '7', 'team_status_id' => '9'),
            array('study_id' => '7', 'team_status_id' => '10'),
            array('study_id' => '7', 'team_status_id' => '11'),
            array('study_id' => '8', 'team_status_id' => '1'),
            array('study_id' => '8', 'team_status_id' => '2'),
            array('study_id' => '8', 'team_status_id' => '3'),
            array('study_id' => '8', 'team_status_id' => '4'),
            array('study_id' => '8', 'team_status_id' => '5'),
            array('study_id' => '8', 'team_status_id' => '6'),
            array('study_id' => '8', 'team_status_id' => '7'),
            array('study_id' => '8', 'team_status_id' => '8'),
            array('study_id' => '8', 'team_status_id' => '9'),
            array('study_id' => '8', 'team_status_id' => '10'),
            array('study_id' => '8', 'team_status_id' => '11'),
            array('study_id' => '9', 'team_status_id' => '1'),
            array('study_id' => '9', 'team_status_id' => '2'),
            array('study_id' => '9', 'team_status_id' => '3'),
            array('study_id' => '9', 'team_status_id' => '4'),
            array('study_id' => '9', 'team_status_id' => '5'),
            array('study_id' => '9', 'team_status_id' => '6'),
            array('study_id' => '9', 'team_status_id' => '7'),
            array('study_id' => '9', 'team_status_id' => '8'),
            array('study_id' => '9', 'team_status_id' => '9'),
            array('study_id' => '9', 'team_status_id' => '10'),
            array('study_id' => '9', 'team_status_id' => '11'),
            array('study_id' => '10', 'team_status_id' => '1'),
            array('study_id' => '10', 'team_status_id' => '2'),
            array('study_id' => '10', 'team_status_id' => '3'),
            array('study_id' => '10', 'team_status_id' => '4'),
            array('study_id' => '10', 'team_status_id' => '5'),
            array('study_id' => '10', 'team_status_id' => '6'),
            array('study_id' => '10', 'team_status_id' => '7'),
            array('study_id' => '10', 'team_status_id' => '8'),
            array('study_id' => '11', 'team_status_id' => '1'),
            array('study_id' => '11', 'team_status_id' => '2'),
            array('study_id' => '11', 'team_status_id' => '3'),
            array('study_id' => '11', 'team_status_id' => '4'),
            array('study_id' => '11', 'team_status_id' => '5'),
            array('study_id' => '11', 'team_status_id' => '6'),
            array('study_id' => '11', 'team_status_id' => '7'),
            array('study_id' => '11', 'team_status_id' => '8'),
            array('study_id' => '11', 'team_status_id' => '9'),
            array('study_id' => '11', 'team_status_id' => '10'),
            array('study_id' => '11', 'team_status_id' => '11')
        );

        if (is_array($study_team_status) && count($study_team_status)) {
            DB::table('study_team_status')->insert($study_team_status);
        }
    }
}
