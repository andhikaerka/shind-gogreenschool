<?php

use App\Recommendation;
use Illuminate\Database\Seeder;

class RecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recommendations = array(
            array('id' => '1', 'cadre_activity_id' => '1', 'recommendation' => 'Di tingkatkan pengawasan jadwal piket pokja dan cleaning service perlu dilatih kompos', 'pending' => NULL, 'continue' => NULL, 'created_at' => '2020-08-13 05:42:13', 'updated_at' => '2020-09-17 18:40:25'),
            array('id' => '2', 'cadre_activity_id' => '4', 'recommendation' => 'Mengikuti lomba busana daur ulang', 'pending' => NULL, 'continue' => NULL, 'created_at' => '2020-08-22 14:38:53', 'updated_at' => '2020-08-22 14:39:39')
        );

        if (is_array($recommendations) && count($recommendations)) {
            Recommendation::query()->insert($recommendations);
        }
    }
}
