<?php

use App\PartnerActivity;
use Illuminate\Database\Seeder;

class PartnerActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $partner_activities = array(
            array('id' => '1', 'slug' => 'kerjabakti-di-masyarakat-sekitar-sekolah-pengolahan-sampah', 'name' => 'Kerjabakti di masyarakat sekitar sekolah ( pengolahan sampah )', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '2', 'slug' => 'kerjabakti-di-masyarakat-sekitar-sekolah-hemat-energi', 'name' => 'Kerjabakti di masyarakat sekitar sekolah ( hemat energi )', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '3', 'slug' => 'kerjabakti-di-masyarakat-sekitar-sekolah-pelestarian-air', 'name' => 'Kerjabakti di masyarakat sekitar sekolah ( Pelestarian air )', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '4', 'slug' => 'kerjabakti-di-masyarakat-sekitar-sekolah-perlindungan-kehati', 'name' => 'Kerjabakti di masyarakat sekitar sekolah ( Perlindungan Kehati)', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '5', 'slug' => 'kerjabakti-di-masyarakat-sekitar-sekolah-pengelolaan-kantin-sehat', 'name' => 'Kerjabakti di masyarakat sekitar sekolah ( Pengelolaan Kantin sehat )', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '6', 'slug' => 'pelatihan-teknis-dengan-pihak-lain', 'name' => 'Pelatihan teknis dengan pihak lain', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '7', 'slug' => 'kegiatan-massal-lingkungan-bersama-pihak-lain', 'name' => 'Kegiatan massal Lingkungan bersama pihak lain', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '8', 'slug' => 'membangun-jaringan-komunikasi-dengan-komunitas-lingkungan', 'name' => 'Membangun jaringan komunikasi dengan komunitas lingkungan', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '9', 'slug' => 'publikasi-melalui-media-radio', 'name' => 'Publikasi melalui media radio', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '10', 'slug' => 'publikasi-melalui-media-tv', 'name' => 'Publikasi melalui media TV', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '11', 'slug' => 'publikasi-melalui-media-koran', 'name' => 'Publikasi melalui media koran', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '12', 'slug' => 'seminar-workshop-dengan-pihak-lain', 'name' => 'Seminar / workshop dengan pihak lain', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '13', 'slug' => 'baksos-lingkungan-di-wilayah-lain', 'name' => 'Baksos lingkungan di wilayah lain', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '14', 'slug' => 'seremonial-lingkungan-hidup-dengan-pemerintah-dinas', 'name' => 'Seremonial Lingkungan Hidup dengan Pemerintah/Dinas', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '15', 'slug' => 'pameran-terkait-lh-dengan-pihak-lain', 'name' => 'Pameran terkait LH dengan pihak lain', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '16', 'slug' => 'Pembinaan teknis dengan sekolah mitra/imbas', 'name' => 'Pembinaan teknis dengan sekolah mitra/imbas', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '17', 'slug' => '1', 'name' => '1', 'created_at' => '2020-08-18 06:04:49', 'updated_at' => '2020-08-18 06:04:49'),
            array('id' => '18', 'slug' => '2', 'name' => '2', 'created_at' => '2020-08-18 06:06:32', 'updated_at' => '2020-08-18 06:06:32'),
            array('id' => '19', 'slug' => '3', 'name' => '3', 'created_at' => '2020-08-18 06:08:31', 'updated_at' => '2020-08-18 06:08:31'),
            array('id' => '20', 'slug' => '4', 'name' => '4', 'created_at' => '2020-08-18 06:11:52', 'updated_at' => '2020-08-18 06:11:52'),
            array('id' => '21', 'slug' => '9', 'name' => '9', 'created_at' => '2020-08-18 06:13:33', 'updated_at' => '2020-08-18 06:13:33'),
            array('id' => '22', 'slug' => '8', 'name' => '8', 'created_at' => '2020-08-18 06:15:06', 'updated_at' => '2020-08-18 06:15:06')
        );

        if (is_array($partner_activities) && count($partner_activities)) {
            PartnerActivity::query()->insert($partner_activities);
        }
    }
}
