<?php

use App\ParentChecklistTemplate;
use Illuminate\Database\Seeder;

class ParentChecklistTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent_checklist_templates = array(
            array('id' => '1', 'slug' => 'reduce-dan-reuse', 'name' => 'Reduce dan Reuse', 'select_all' => '0', 'created_at' => '2020-04-11 20:23:54', 'updated_at' => '2020-04-11 20:23:54'),
            array('id' => '2', 'slug' => 'recycle', 'name' => 'Recycle', 'select_all' => '0', 'created_at' => '2020-04-11 20:24:10', 'updated_at' => '2020-04-11 20:24:10'),
            array('id' => '3', 'slug' => 'kegiatan-penghijauan-yang-dilakukan', 'name' => 'Kegiatan penghijauan yang dilakukan', 'select_all' => '1', 'created_at' => '2020-04-11 20:24:10', 'updated_at' => '2020-04-11 20:24:10'),
        );

        if (is_array($parent_checklist_templates) && count($parent_checklist_templates)) {
            ParentChecklistTemplate::query()->insert($parent_checklist_templates);
        }
    }
}
