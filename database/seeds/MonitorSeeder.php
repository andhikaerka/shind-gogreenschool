<?php

use App\Monitor;
use Illuminate\Database\Seeder;

class MonitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $monitors = array(
            array('id' => '1', 'date' => '2020-11-03', 'work_group_id' => '1', 'created_at' => '2020-08-13 05:35:27', 'updated_at' => '2020-08-13 05:35:27'),
            array('id' => '2', 'date' => '2020-07-08', 'work_group_id' => '4', 'created_at' => '2020-08-13 05:36:26', 'updated_at' => '2020-08-13 05:36:26'),
            array('id' => '3', 'date' => '2020-08-17', 'work_group_id' => '5', 'created_at' => '2020-08-13 05:37:31', 'updated_at' => '2020-08-13 05:37:31'),
            array('id' => '5', 'date' => '2020-05-07', 'work_group_id' => '9', 'created_at' => '2020-08-13 05:38:59', 'updated_at' => '2020-08-13 05:38:59'),
            array('id' => '6', 'date' => '2020-07-27', 'work_group_id' => '2', 'created_at' => '2020-08-13 07:18:14', 'updated_at' => '2020-08-13 07:18:14')
        );

        if (is_array($monitors) && count($monitors)) {
            Monitor::query()->insert($monitors);
        }
    }
}
