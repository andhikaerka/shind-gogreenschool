<?php

use App\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = array(
            array('id' => '1', 'user_id' => '6', 'name' => 'HARJONO, S.PD', 'team_status_id' => '2', 'gender' => '1', 'birth_date' => '1967-08-17', 'work_group_id' => '1', 'job_description' => 'MEMBUAT KERJASAMA SEKOLAH DGN PIHAK LAIN,
MEMASTIKAN KOMPOS JADI BISA DIGUNAKAN,
MELAKUKAN MONITORIN', 'team_position_id' => '1', 'another_position' => NULL, 'created_at' => '2020-08-04 09:42:04', 'updated_at' => '2020-11-27 01:08:41'),
            array('id' => '2', 'user_id' => '18', 'name' => 'Wulandari S.Pd', 'team_status_id' => '3', 'gender' => '2', 'birth_date' => '2020-07-27', 'work_group_id' => '4', 'job_description' => 'Mendampingi siswa pokja energi', 'team_position_id' => '3', 'another_position' => NULL, 'created_at' => '2020-08-13 08:29:59', 'updated_at' => '2020-08-13 08:29:59')
        );

        if (is_array($teams) && count($teams)) {
            Team::query()->insert($teams);
        }
    }
}
