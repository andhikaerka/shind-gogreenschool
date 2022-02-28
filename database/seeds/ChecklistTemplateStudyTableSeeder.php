<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChecklistTemplateStudyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $checklist_template_study = array(
            array('checklist_template_id' => '21', 'study_id' => '1'),
            array('checklist_template_id' => '20', 'study_id' => '2'),
            array('checklist_template_id' => '27', 'study_id' => '2'),
            array('checklist_template_id' => '30', 'study_id' => '3'),
            array('checklist_template_id' => '39', 'study_id' => '4'),
            array('checklist_template_id' => '40', 'study_id' => '4'),
            array('checklist_template_id' => '41', 'study_id' => '4'),
            array('checklist_template_id' => '50', 'study_id' => '5'),
            array('checklist_template_id' => '52', 'study_id' => '6'),
            array('checklist_template_id' => '51', 'study_id' => '5'),
            array('checklist_template_id' => '36', 'study_id' => '3'),
            array('checklist_template_id' => '34', 'study_id' => '7'),
            array('checklist_template_id' => '38', 'study_id' => '7'),
            array('checklist_template_id' => '18', 'study_id' => '8'),
            array('checklist_template_id' => '22', 'study_id' => '9'),
            array('checklist_template_id' => '43', 'study_id' => '10'),
            array('checklist_template_id' => '58', 'study_id' => '11')
        );

        if (is_array($checklist_template_study) && count($checklist_template_study)) {
            DB::table('checklist_template_study')->insert($checklist_template_study);
        }
    }
}
