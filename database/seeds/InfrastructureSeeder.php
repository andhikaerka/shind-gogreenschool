<?php

use App\Infrastructure;
use Illuminate\Database\Seeder;

class InfrastructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $infrastructures = array(
            array('id' => '1', 'work_group_id' => '1', 'name' => 'TONG KOMPOSTER', 'aspect_id' => '1', 'total' => '8', 'function' => 'MENGOLAH SAMPAH ORGANIK, MENGURANGI TUMPUAN SAMPAH DI SEKOLAH, SEBAGAI MEDIA BELAJAR', 'pic' => 'IBU. MAYA ANGGINI , M.PD', 'created_at' => '2020-08-04 09:33:46', 'updated_at' => '2020-08-04 09:33:46'),
            array('id' => '2', 'work_group_id' => '3', 'name' => 'Timbangan digital', 'aspect_id' => '1', 'total' => '2', 'function' => 'Menimbang sampah plastik dan kertas dll', 'pic' => 'Sudirja', 'created_at' => '2020-08-12 21:59:36', 'updated_at' => '2020-08-12 21:59:36'),
            array('id' => '3', 'work_group_id' => '7', 'name' => 'Bor Biopori', 'aspect_id' => '4', 'total' => '10', 'function' => 'Membuat lubang resapan biopori dll', 'pic' => 'Supriyadi, S.Pd', 'created_at' => '2020-08-12 22:00:43', 'updated_at' => '2020-08-12 22:00:43'),
            array('id' => '4', 'work_group_id' => '5', 'name' => 'Greenhouse', 'aspect_id' => '3', 'total' => '1', 'function' => 'Budidaya tanaman hidroponik, dll', 'pic' => 'Subarjo,S.Pd', 'created_at' => '2020-08-12 22:01:47', 'updated_at' => '2020-08-12 22:01:47'),
            array('id' => '5', 'work_group_id' => '9', 'name' => 'Tempat sampah terpilah', 'aspect_id' => '5', 'total' => '6', 'function' => 'Menaruh sampah di Kantin, dll', 'pic' => 'Aditya nur hadi', 'created_at' => '2020-08-12 22:02:45', 'updated_at' => '2020-08-12 22:02:45'),
            array('id' => '6', 'work_group_id' => '8', 'name' => 'Sumur resapan', 'aspect_id' => '4', 'total' => '23', 'function' => 'Meresapkan air dll', 'pic' => 'rima melati', 'created_at' => '2020-08-12 22:04:07', 'updated_at' => '2020-08-12 22:04:07'),
            array('id' => '7', 'work_group_id' => '4', 'name' => 'Panel Surya', 'aspect_id' => '2', 'total' => '1', 'function' => 'Merubah sinar matahari menjadi energi listrik, dll', 'pic' => 'agus', 'created_at' => '2020-08-12 22:05:09', 'updated_at' => '2020-08-12 22:05:09'),
            array('id' => '8', 'work_group_id' => '3', 'name' => 'Gerobak sampah', 'aspect_id' => '1', 'total' => '1', 'function' => 'Mengantar barang ke bank sampah', 'pic' => 'narto wijoyo', 'created_at' => '2020-08-12 22:06:25', 'updated_at' => '2020-08-12 22:06:25'),
            array('id' => '9', 'work_group_id' => '5', 'name' => 'Pompa DC', 'aspect_id' => '3', 'total' => '2', 'function' => 'Menaikkan air ke instalasi hidroponik', 'pic' => 'Murni', 'created_at' => '2020-08-12 22:09:40', 'updated_at' => '2020-08-12 22:09:40'),
            array('id' => '10', 'work_group_id' => '1', 'name' => 'Sapu lidi', 'aspect_id' => '1', 'total' => '23', 'function' => 'Membersihkan halaman sekolah dll', 'pic' => 'wahyu', 'created_at' => '2020-08-12 22:10:37', 'updated_at' => '2020-11-27 01:09:50'),
            array('id' => '11', 'work_group_id' => '1', 'name' => 'Thermometer', 'aspect_id' => '1', 'total' => '5', 'function' => 'Mengukur suhu didalam komposter, dll', 'pic' => 'rina', 'created_at' => '2020-08-12 22:11:34', 'updated_at' => '2020-08-12 22:11:34'),
            array('id' => '12', 'work_group_id' => '4', 'name' => 'Box Panel', 'aspect_id' => '2', 'total' => '1', 'function' => 'Mengatur daya listrik', 'pic' => 'wulandari .S.Pd', 'created_at' => '2020-08-13 08:32:45', 'updated_at' => '2020-08-13 08:32:45')
        );

        if (is_array($infrastructures) && count($infrastructures)) {
            Infrastructure::query()->insert($infrastructures);
        }
    }
}
