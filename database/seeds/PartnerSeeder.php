<?php

use App\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $partners = array(
            array('id' => '1', 'school_profile_id' => '1', 'name' => 'LSM SHIND JOGJA', 'cp_name' => 'MAULANA', 'cp_phone' => '0897287388788', 'partner_category_id' => '6', 'partner_activity_id' => '6', 'date' => '2019-08-12', 'purpose' => 'MELATIH KOMPOSTING AGAR KADER BISA MENANGANI MASALAH PRODUKSINYA.', 'total_people' => '60', 'created_at' => '2020-08-04 13:57:28', 'updated_at' => '2020-08-04 13:57:28'),
            array('id' => '2', 'school_profile_id' => '1', 'name' => 'PT Gogreen', 'cp_name' => 'Mustofa', 'cp_phone' => '082138751155', 'partner_category_id' => '10', 'partner_activity_id' => '3', 'date' => '2020-08-04', 'purpose' => 'Membersihkan kawasan lingkungan sekitar sekolah', 'total_people' => '116', 'created_at' => '2020-08-12 22:44:27', 'updated_at' => '2020-08-12 22:44:27'),
            array('id' => '3', 'school_profile_id' => '1', 'name' => 'SUrya Global', 'cp_name' => 'Bagus Arianto', 'cp_phone' => '089767268937299', 'partner_category_id' => '4', 'partner_activity_id' => '17', 'date' => '2020-08-03', 'purpose' => 'Sekolah bersih', 'total_people' => '120', 'created_at' => '2020-08-18 06:04:49', 'updated_at' => '2020-08-18 06:04:49'),
            array('id' => '4', 'school_profile_id' => '1', 'name' => 'Panel Surya', 'cp_name' => 'Mustofa', 'cp_phone' => '082138751155', 'partner_category_id' => '10', 'partner_activity_id' => '18', 'date' => '2020-08-11', 'purpose' => 'hemat energi', 'total_people' => '20', 'created_at' => '2020-08-18 06:06:32', 'updated_at' => '2020-08-18 06:06:32'),
            array('id' => '5', 'school_profile_id' => '1', 'name' => 'Tri Water', 'cp_name' => 'Basuki', 'cp_phone' => '082138751155', 'partner_category_id' => '3', 'partner_activity_id' => '19', 'date' => '2020-08-10', 'purpose' => 'Hemat air', 'total_people' => '34', 'created_at' => '2020-08-18 06:08:31', 'updated_at' => '2020-08-18 06:08:31'),
            array('id' => '6', 'school_profile_id' => '1', 'name' => 'DLH Kota', 'cp_name' => 'Bani', 'cp_phone' => '08782675737', 'partner_category_id' => '9', 'partner_activity_id' => '20', 'date' => '2020-08-06', 'purpose' => 'Mengenal kehati', 'total_people' => '8', 'created_at' => '2020-08-18 06:11:52', 'updated_at' => '2020-08-18 06:11:52'),
            array('id' => '7', 'school_profile_id' => '1', 'name' => 'Dinas Pendidikan', 'cp_name' => 'Susi', 'cp_phone' => '087862783868', 'partner_category_id' => '8', 'partner_activity_id' => '21', 'date' => '2020-08-11', 'purpose' => 'Talkshow RRI', 'total_people' => '2', 'created_at' => '2020-08-18 06:13:33', 'updated_at' => '2020-08-18 06:13:33'),
            array('id' => '8', 'school_profile_id' => '1', 'name' => 'UNS', 'cp_name' => 'Suprihati', 'cp_phone' => '089736868468', 'partner_category_id' => '4', 'partner_activity_id' => '22', 'date' => '2020-08-05', 'purpose' => 'Membuat talkshow radio', 'total_people' => '23', 'created_at' => '2020-08-18 06:15:06', 'updated_at' => '2020-08-18 06:15:06'),
            array('id' => '9', 'school_profile_id' => '1', 'name' => 'UNS', 'cp_name' => 'Suprihati', 'cp_phone' => '089736868468', 'partner_category_id' => '4', 'partner_activity_id' => '22', 'date' => '2020-08-13', 'purpose' => 'Membuat talkshow radio', 'total_people' => '23', 'created_at' => '2020-08-18 06:15:47', 'updated_at' => '2020-08-18 06:15:47'),
            array('id' => '10', 'school_profile_id' => '1', 'name' => 'UNS', 'cp_name' => 'Suprihati', 'cp_phone' => '089736868468', 'partner_category_id' => '4', 'partner_activity_id' => '22', 'date' => '2020-07-27', 'purpose' => 'Membuat talkshow radio', 'total_people' => '23', 'created_at' => '2020-08-18 06:16:56', 'updated_at' => '2020-08-18 06:16:56')
        );

        if (is_array($partners) && count($partners)) {
            Partner::query()->insert($partners);
        }
    }
}
