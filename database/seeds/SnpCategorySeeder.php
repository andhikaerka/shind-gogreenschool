<?php

use App\PartnerCategory;
use App\SnpCategory;
use Illuminate\Database\Seeder;

class SnpCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $snp_categories = array(
            array('id' => '1', 'slug' => 'standar-isi', 'name' => 'Standar Isi'),
            array('id' => '2', 'slug' => 'standar-proses', 'name' => 'Standar Proses'),
            array('id' => '3', 'slug' => 'standar-kompetensi-lulusan', 'name' => 'Standar Kompetensi Lulusan'),
            array('id' => '4', 'slug' => 'standar-pendidik-dan-tenaga-kependidikan', 'name' => 'Standar Pendidik dan Tenaga Kependidikan'),
            array('id' => '5', 'slug' => 'standar-sarana-dan-prasarana', 'name' => 'Standar Sarana dan Prasarana'),
            array('id' => '6', 'slug' => 'standar-pengelolaan', 'name' => 'Standar Pengelolaan'),
            array('id' => '7', 'slug' => 'standar-pembiayaan', 'name' => 'Standar Pembiayaan'),
            array('id' => '8', 'slug' => 'standar-penilaian-pendidikan', 'name' => 'Standar Penilaian Pendidikan'),
        );

        if (is_array($snp_categories) && count($snp_categories)) {
            SnpCategory::query()->insert($snp_categories);
        }
    }
}
