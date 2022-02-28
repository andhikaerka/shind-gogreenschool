<?php

use App\Curriculum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $curricula = array(
            array('id' => '1','school_profile_id' => '1','vision' => 'BERBUDAYA DAN CINTA LINGKUNGAN HIDUP','mission' => 'MENJADIKAN TEMPAT PENDIDIKAN YANG ASRI,BERSIH,HIJAU','purpose' => 'CIPTAKAN LULUSAN PEDULI LINGKUNGAN HIDUP','created_at' => '2020-08-04 14:04:03','updated_at' => '2020-08-26 14:30:48')
        );

        if (is_array($curricula) && count($curricula)) {
            Curriculum::query()->insert($curricula);
        }
    }
}
