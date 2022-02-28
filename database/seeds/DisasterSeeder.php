<?php

use App\Disaster;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $disasters = array(
            array('id' => '1', 'school_profile_id' => '1', 'threat' => 'BANJIR , PUTING BELIUNG', 'potential' => 'HALAMAN LUAS DAN BANYAK POHON', 'anticipation' => 'Membuat sumur resapan dan lubang biopori', 'vulnerability' => 'TENGAH KOTA PADAT PEMUKIMAN', 'impact' => 'TERNDAM SISWA TIDAK MASUK', 'created_at' => '2020-08-04 09:36:08', 'updated_at' => '2020-08-04 09:36:08')
        );

        if (is_array($disasters) && count($disasters)) {
            Disaster::query()->insert($disasters);
        }

        /*$disaster_disaster_threat = array(
            array('disaster_id' => '1', 'disaster_threat_id' => '1')
        );

        if (is_array($disaster_disaster_threat) && count($disaster_disaster_threat)) {
            DB::table('disaster_disaster_threat')->insert($disaster_disaster_threat);
        }*/
    }
}
