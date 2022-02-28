<?php

use App\Assessment;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assessments = array(
            array('id' => '1', 'school_profile_id' => '1', 'component_1' => '3', 'component_2' => '3', 'component_3' => '3', 'component_4' => '5', 'component_5' => '5', 'component_6' => '3', 'component_7' => '3', 'component_8' => '5', 'component_9' => '3', 'component_10' => '3', 'component_11' => '5', 'component_12' => '3', 'component_13' => '3', 'component_14' => '5', 'component_15' => '5', 'component_16' => '3', 'component_17' => '3', 'component_18' => '3', 'component_19' => '3', 'component_20' => '5', 'component_21' => '5', 'component_22' => '3', 'component_23' => '5', 'component_24' => '5', 'component_25' => '3', 'component_26' => '5', 'component_27' => '3', 'component_28' => '0', 'component_29' => '0', 'created_at' => '2020-09-16 22:59:41', 'updated_at' => '2020-09-16 22:59:41'),
            array('id' => '2', 'school_profile_id' => '2', 'component_1' => '2', 'component_2' => '2', 'component_3' => '2', 'component_4' => '3', 'component_5' => '3', 'component_6' => '2', 'component_7' => '2', 'component_8' => '2', 'component_9' => '2', 'component_10' => '2', 'component_11' => '3', 'component_12' => '2', 'component_13' => '2', 'component_14' => '3', 'component_15' => '2', 'component_16' => '2', 'component_17' => '2', 'component_18' => '2', 'component_19' => '2', 'component_20' => '2', 'component_21' => '3', 'component_22' => '1', 'component_23' => '3', 'component_24' => '3', 'component_25' => '2', 'component_26' => '4', 'component_27' => '2', 'component_28' => '0', 'component_29' => '0', 'created_at' => '2020-11-18 11:21:10', 'updated_at' => '2020-11-18 11:21:10'),
            array('id' => '3', 'school_profile_id' => '6', 'component_1' => '3', 'component_2' => '3', 'component_3' => '3', 'component_4' => '5', 'component_5' => '5', 'component_6' => '3', 'component_7' => '3', 'component_8' => '5', 'component_9' => '3', 'component_10' => '3', 'component_11' => '5', 'component_12' => '3', 'component_13' => '3', 'component_14' => '5', 'component_15' => '5', 'component_16' => '3', 'component_17' => '3', 'component_18' => '3', 'component_19' => '3', 'component_20' => '5', 'component_21' => '5', 'component_22' => '3', 'component_23' => '5', 'component_24' => '5', 'component_25' => '3', 'component_26' => '5', 'component_27' => '3', 'component_28' => '0', 'component_29' => '0', 'created_at' => '2020-11-26 01:21:09', 'updated_at' => '2020-11-26 01:21:09')
        );

        if (is_array($assessments) && count($assessments)) {
            Assessment::query()->insert($assessments);
        }
    }
}
