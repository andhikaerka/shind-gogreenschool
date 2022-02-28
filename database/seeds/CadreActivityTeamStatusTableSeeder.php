<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CadreActivityTeamStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cadre_activity_team_status = array(
            array('cadre_activity_id' => '1', 'team_status_id' => '1'),
            array('cadre_activity_id' => '1', 'team_status_id' => '2'),
            array('cadre_activity_id' => '1', 'team_status_id' => '3'),
            array('cadre_activity_id' => '1', 'team_status_id' => '4'),
            array('cadre_activity_id' => '1', 'team_status_id' => '5'),
            array('cadre_activity_id' => '1', 'team_status_id' => '6'),
            array('cadre_activity_id' => '2', 'team_status_id' => '2'),
            array('cadre_activity_id' => '2', 'team_status_id' => '3'),
            array('cadre_activity_id' => '2', 'team_status_id' => '5'),
            array('cadre_activity_id' => '2', 'team_status_id' => '6'),
            array('cadre_activity_id' => '2', 'team_status_id' => '8'),
            array('cadre_activity_id' => '2', 'team_status_id' => '9'),
            array('cadre_activity_id' => '2', 'team_status_id' => '11'),
            array('cadre_activity_id' => '3', 'team_status_id' => '1'),
            array('cadre_activity_id' => '3', 'team_status_id' => '2'),
            array('cadre_activity_id' => '3', 'team_status_id' => '3'),
            array('cadre_activity_id' => '3', 'team_status_id' => '4'),
            array('cadre_activity_id' => '3', 'team_status_id' => '5'),
            array('cadre_activity_id' => '3', 'team_status_id' => '6'),
            array('cadre_activity_id' => '3', 'team_status_id' => '7'),
            array('cadre_activity_id' => '3', 'team_status_id' => '8'),
            array('cadre_activity_id' => '3', 'team_status_id' => '9'),
            array('cadre_activity_id' => '3', 'team_status_id' => '10'),
            array('cadre_activity_id' => '3', 'team_status_id' => '11'),
            array('cadre_activity_id' => '4', 'team_status_id' => '1'),
            array('cadre_activity_id' => '4', 'team_status_id' => '2'),
            array('cadre_activity_id' => '4', 'team_status_id' => '3'),
            array('cadre_activity_id' => '4', 'team_status_id' => '4'),
            array('cadre_activity_id' => '4', 'team_status_id' => '5'),
            array('cadre_activity_id' => '4', 'team_status_id' => '6'),
            array('cadre_activity_id' => '4', 'team_status_id' => '7'),
            array('cadre_activity_id' => '4', 'team_status_id' => '8'),
            array('cadre_activity_id' => '4', 'team_status_id' => '9'),
            array('cadre_activity_id' => '4', 'team_status_id' => '10'),
            array('cadre_activity_id' => '4', 'team_status_id' => '11'),
            array('cadre_activity_id' => '5', 'team_status_id' => '1'),
            array('cadre_activity_id' => '5', 'team_status_id' => '2'),
            array('cadre_activity_id' => '5', 'team_status_id' => '3'),
            array('cadre_activity_id' => '5', 'team_status_id' => '4'),
            array('cadre_activity_id' => '5', 'team_status_id' => '5'),
            array('cadre_activity_id' => '5', 'team_status_id' => '6'),
            array('cadre_activity_id' => '5', 'team_status_id' => '7'),
            array('cadre_activity_id' => '5', 'team_status_id' => '8'),
            array('cadre_activity_id' => '5', 'team_status_id' => '9'),
            array('cadre_activity_id' => '5', 'team_status_id' => '10'),
            array('cadre_activity_id' => '5', 'team_status_id' => '11'),
            array('cadre_activity_id' => '6', 'team_status_id' => '1'),
            array('cadre_activity_id' => '6', 'team_status_id' => '2'),
            array('cadre_activity_id' => '6', 'team_status_id' => '3'),
            array('cadre_activity_id' => '6', 'team_status_id' => '4'),
            array('cadre_activity_id' => '6', 'team_status_id' => '5'),
            array('cadre_activity_id' => '6', 'team_status_id' => '6'),
            array('cadre_activity_id' => '6', 'team_status_id' => '11'),
            array('cadre_activity_id' => '7', 'team_status_id' => '2'),
            array('cadre_activity_id' => '7', 'team_status_id' => '3'),
            array('cadre_activity_id' => '7', 'team_status_id' => '4'),
            array('cadre_activity_id' => '7', 'team_status_id' => '5'),
            array('cadre_activity_id' => '7', 'team_status_id' => '6'),
            array('cadre_activity_id' => '7', 'team_status_id' => '7'),
            array('cadre_activity_id' => '7', 'team_status_id' => '8'),
            array('cadre_activity_id' => '7', 'team_status_id' => '9'),
            array('cadre_activity_id' => '7', 'team_status_id' => '10'),
            array('cadre_activity_id' => '7', 'team_status_id' => '11'),
            array('cadre_activity_id' => '8', 'team_status_id' => '1'),
            array('cadre_activity_id' => '8', 'team_status_id' => '2'),
            array('cadre_activity_id' => '8', 'team_status_id' => '3'),
            array('cadre_activity_id' => '8', 'team_status_id' => '4'),
            array('cadre_activity_id' => '8', 'team_status_id' => '5'),
            array('cadre_activity_id' => '8', 'team_status_id' => '6'),
            array('cadre_activity_id' => '8', 'team_status_id' => '7'),
            array('cadre_activity_id' => '8', 'team_status_id' => '10'),
            array('cadre_activity_id' => '9', 'team_status_id' => '1'),
            array('cadre_activity_id' => '9', 'team_status_id' => '2'),
            array('cadre_activity_id' => '9', 'team_status_id' => '3'),
            array('cadre_activity_id' => '9', 'team_status_id' => '4'),
            array('cadre_activity_id' => '9', 'team_status_id' => '5'),
            array('cadre_activity_id' => '9', 'team_status_id' => '6'),
            array('cadre_activity_id' => '9', 'team_status_id' => '7'),
            array('cadre_activity_id' => '9', 'team_status_id' => '8'),
            array('cadre_activity_id' => '9', 'team_status_id' => '9'),
            array('cadre_activity_id' => '9', 'team_status_id' => '10'),
            array('cadre_activity_id' => '9', 'team_status_id' => '11')
        );

        if (is_array($cadre_activity_team_status) && count($cadre_activity_team_status)) {
            DB::table('cadre_activity_team_status')->insert($cadre_activity_team_status);
        }
    }
}
