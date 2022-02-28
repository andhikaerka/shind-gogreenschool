<?php

use App\Innovation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InnovationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $innovations = array(
            array('id' => '1', 'name' => 'KOMPOSTING ORGANIK', 'work_group_id' => '1', 'activity' => 'MEMBUAT KOMPOS DENGAN AKTIVATOR NON KIMIA DALAM WAKTU 1 MINGGU', 'tutor' => 'IBU. MAYA ANGGINI , M.PD', 'purpose' => 'MENGURANGI PENGGUNAAN ZAT KIMIA DAN MEMPERCEPAT PROSES DARI 1 BULAN MENJADI 1 MINGGU', 'advantage' => 'DAPAT MENANGANI SAMPAH DENGAN CEPAT KERENA PROSES CEPAT', 'innovation' => 'MUDAH,CEPAT TIDAK BERBAU TANPA ZAT KIMIA', 'created_at' => '2020-08-04 19:59:17', 'updated_at' => '2020-08-04 19:59:17'),
            array('id' => '2', 'name' => 'Panel surya', 'work_group_id' => '4', 'activity' => 'Menghidupkan pompa greenhouse dengan tenaga surya', 'tutor' => 'Ir. Edi sukendra, M.Pd', 'purpose' => 'Hemat energi', 'advantage' => 'Mengurangi beban daya listrik', 'innovation' => 'Pompa hidup tenaga surya', 'created_at' => '2020-08-18 06:49:34', 'updated_at' => '2020-08-18 06:49:34'),
            array('id' => '3', 'name' => 'Burung Hantu', 'work_group_id' => '10', 'activity' => 'Konservasi burung hantu', 'tutor' => 'Susilo Atmojo, S.Pd', 'purpose' => 'Menjaga kepunahan burung hantu perkotaan', 'advantage' => 'Menambah ekosistem', 'innovation' => 'Untuk materi pembelajaran', 'created_at' => '2020-08-18 06:52:10', 'updated_at' => '2020-08-18 06:52:10')
        );

        if (is_array($innovations) && count($innovations)) {
            Innovation::query()->insert($innovations);
        }
    }
}
