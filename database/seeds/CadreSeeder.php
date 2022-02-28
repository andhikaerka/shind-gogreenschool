<?php

use App\Cadre;
use Illuminate\Database\Seeder;

class CadreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cadres = array(
            array('id' => '1', 'work_group_id' => '1', 'user_id' => '7', 'gender' => '1', 'class' => '8', 'phone' => '089738799473', 'birth_date' => '2004-07-22', 'address' => 'LAWEYAN SURAKARTA', 'hobby' => 'MEMBACA FOTOGRAFER JALAN JALAN DLL', 'position' => 'Ketua', 'created_at' => '2020-08-04 14:11:38', 'updated_at' => '2020-08-04 14:11:38'),
            array('id' => '2', 'work_group_id' => '1', 'user_id' => '17', 'gender' => '2', 'class' => '7', 'phone' => '089672757573', 'birth_date' => '2020-07-29', 'address' => 'solo', 'hobby' => 'membaca', 'position' => 'Ketua', 'created_at' => '2020-08-12 22:46:58', 'updated_at' => '2020-08-12 22:46:58'),
            array('id' => '3', 'work_group_id' => '1', 'user_id' => '44', 'gender' => '1', 'class' => '7', 'phone' => '082138751155', 'birth_date' => '2004-03-23', 'address' => 'Jl Masjid no 89', 'hobby' => 'membaca', 'position' => 'Anggota', 'created_at' => '2020-11-20 12:56:14', 'updated_at' => '2020-11-20 12:57:05')
        );

        if (is_array($cadres) && count($cadres)) {
            Cadre::query()->insert($cadres);
        }
    }
}
