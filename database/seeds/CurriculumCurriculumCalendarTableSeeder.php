<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurriculumCurriculumCalendarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $curriculum_curriculum_calendar = array(
            array('curriculum_id' => '1', 'curriculum_calendar_id' => '1'),
            array('curriculum_id' => '1', 'curriculum_calendar_id' => '2'),
            array('curriculum_id' => '1', 'curriculum_calendar_id' => '3'),
            array('curriculum_id' => '1', 'curriculum_calendar_id' => '4'),
            array('curriculum_id' => '1', 'curriculum_calendar_id' => '5'),
            array('curriculum_id' => '1', 'curriculum_calendar_id' => '6'),
            array('curriculum_id' => '1', 'curriculum_calendar_id' => '7'),
            array('curriculum_id' => '1', 'curriculum_calendar_id' => '8'),
            array('curriculum_id' => '1', 'curriculum_calendar_id' => '9')
        );

        if (is_array($curriculum_curriculum_calendar) && count($curriculum_curriculum_calendar)) {
            DB::table('curriculum_curriculum_calendar')->insert($curriculum_curriculum_calendar);
        }
    }
}
