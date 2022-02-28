<?php

use App\EnvironmentalStatus;
use Illuminate\Database\Seeder;

class EnvironmentalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $environmental_statuses = array(
            array('id' => '1', 'slug' => 'calon-sekolah-adiwiyata-kab-kota', 'name' => 'Calon Sekolah Adiwiyata Kab/Kota', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '2', 'slug' => 'sekolah-adiwiyata-kab-kota', 'name' => 'Sekolah Adiwiyata Kab/Kota', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '3', 'slug' => 'sekolah-adiwiyata-provinsi', 'name' => 'Sekolah Adiwiyata Provinsi', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '4', 'slug' => 'sekolah-adiwiyata-nasional', 'name' => 'Sekolah Adiwiyata Nasional', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '5', 'slug' => 'sekolah-adiwiyata-mandiri', 'name' => 'Sekolah Adiwiyata Mandiri', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '6', 'slug' => 'sekolah-asean-eco-school', 'name' => 'Sekolah Asean Eco School', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '7', 'slug' => 'go-green-school', 'name' => 'Go Green School', 'created_at' => NULL, 'updated_at' => NULL)
        );

        if (is_array($environmental_statuses) && count($environmental_statuses)) {
            EnvironmentalStatus::query()->insert($environmental_statuses);
        }
    }
}
