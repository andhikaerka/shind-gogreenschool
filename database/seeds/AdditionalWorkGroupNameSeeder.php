<?php

use App\WorkGroupName;
use Illuminate\Database\Seeder;

class AdditionalWorkGroupNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $work_group_names = array(
            array('id' => '20', 'slug' => 'Bijak Plastik Kantin', 'name' => 'Bijak Plastik Kantin', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '21', 'slug' => 'Makanan B2SA ramah LH', 'name' => 'Makanan B2SA ramah LH', 'created_at' => NULL, 'updated_at' => NULL)
        );

        if (is_array($work_group_names) && count($work_group_names)) {
            WorkGroupName::query()->insert($work_group_names);
        }
    }
}
