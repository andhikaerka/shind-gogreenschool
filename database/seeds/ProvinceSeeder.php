<?php

use App\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = array(
            array('id' => '1', 'code' => '11', 'name' => 'ACEH', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '2', 'code' => '12', 'name' => 'SUMATERA UTARA', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '3', 'code' => '13', 'name' => 'SUMATERA BARAT', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '4', 'code' => '14', 'name' => 'RIAU', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '5', 'code' => '15', 'name' => 'JAMBI', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '6', 'code' => '16', 'name' => 'SUMATERA SELATAN', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '7', 'code' => '17', 'name' => 'BENGKULU', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '8', 'code' => '18', 'name' => 'LAMPUNG', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '9', 'code' => '19', 'name' => 'KEPULAUAN BANGKA BELITUNG', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '10', 'code' => '21', 'name' => 'KEPULAUAN RIAU', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '11', 'code' => '31', 'name' => 'DKI JAKARTA', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '12', 'code' => '32', 'name' => 'JAWA BARAT', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '13', 'code' => '33', 'name' => 'JAWA TENGAH', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '14', 'code' => '34', 'name' => 'DI YOGYAKARTA', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '15', 'code' => '35', 'name' => 'JAWA TIMUR', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '16', 'code' => '36', 'name' => 'BANTEN', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '17', 'code' => '51', 'name' => 'BALI', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '18', 'code' => '52', 'name' => 'NUSA TENGGARA BARAT', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '19', 'code' => '53', 'name' => 'NUSA TENGGARA TIMUR', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '20', 'code' => '61', 'name' => 'KALIMANTAN BARAT', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '21', 'code' => '62', 'name' => 'KALIMANTAN TENGAH', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '22', 'code' => '63', 'name' => 'KALIMANTAN SELATAN', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '23', 'code' => '64', 'name' => 'KALIMANTAN TIMUR', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '24', 'code' => '65', 'name' => 'KALIMANTAN UTARA', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '25', 'code' => '71', 'name' => 'SULAWESI UTARA', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '26', 'code' => '72', 'name' => 'SULAWESI TENGAH', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '27', 'code' => '73', 'name' => 'SULAWESI SELATAN', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '28', 'code' => '74', 'name' => 'SULAWESI TENGGARA', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '29', 'code' => '75', 'name' => 'GORONTALO', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '30', 'code' => '76', 'name' => 'SULAWESI BARAT', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '31', 'code' => '81', 'name' => 'MALUKU', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '32', 'code' => '82', 'name' => 'MALUKU UTARA', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '33', 'code' => '91', 'name' => 'PAPUA BARAT', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07'),
            array('id' => '34', 'code' => '94', 'name' => 'PAPUA', 'created_at' => '2020-04-10 04:27:07', 'updated_at' => '2020-04-10 04:27:07')
        );

        if (is_array($provinces) && count($provinces)) {
            Province::query()->insert($provinces);
        }
    }
}
