<?php

use App\PartnerCategory;
use Illuminate\Database\Seeder;

class PartnerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $partner_categories = array(
            array('id' => '1', 'slug' => 'paguyuban-ortu', 'name' => 'Paguyuban Ortu', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '2', 'slug' => 'pemerintah-setempat', 'name' => 'Pemerintah Setempat', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '3', 'slug' => 'dinas-terkait', 'name' => 'Dinas Terkait', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '4', 'slug' => 'perguruan-tinggi', 'name' => 'Perguruan Tinggi', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '5', 'slug' => 'komunitas-lingkungan', 'name' => 'Komunitas Lingkungan', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '6', 'slug' => 'lsm-lingkungan-hidup', 'name' => 'LSM Lingkungan Hidup', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '7', 'slug' => 'pemerintah-nasional', 'name' => 'Pemerintah Nasional', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '8', 'slug' => 'pemerintah-prov', 'name' => 'Pemerintah Prov', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '9', 'slug' => 'pemerintah-kab-kota', 'name' => 'Pemerintah Kab/Kota', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '10', 'slug' => 'dunia-usaha', 'name' => 'Dunia Usaha', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '11', 'slug' => 'media-massa', 'name' => 'Media Massa', 'created_at' => NULL, 'updated_at' => NULL),
        );

        if (is_array($partner_categories) && count($partner_categories)) {
            PartnerCategory::query()->insert($partner_categories);
        }
    }
}
