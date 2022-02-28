<?php

use App\QualityReport;
use Illuminate\Database\Seeder;

class QualityReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quality_reports = array(
            array('id' => '1', 'school_profile_id' => '1', 'has_document' => '0', 'waste_management' => 'MEMILIKI TEMPAT PENAMPUNGAN SAMPAH, MENGOLAH SAMPAH ORGANIK,MEMILIKI BANK SAMPAH, DEE', 'energy_conservation' => 'MELAKUKAN PENGHEMATAN LISTRIK DEEL', 'life_preservation' => 'MEMILIKI TAMAN', 'water_conservation' => 'MEYEDIAKAN WASTAFEL, SEKOLAN AIR HUJAN', 'canteen_management' => 'MEMBUAT KANTIN BARU,MELENGKAPI MEJA KURSI', 'created_at' => '2020-08-04 09:37:51', 'updated_at' => '2020-08-04 09:37:51'),
            array('id' => '2', 'school_profile_id' => '3', 'has_document' => '0', 'waste_management' => 'Mengelola sampah sekolah seperti Komposting, Kerajinan daur ulang dan Bank sampah', 'energy_conservation' => 'Melakukan effisiensi energi listrik dengan audit energi listrik sekolah', 'life_preservation' => 'Merawat dan budidaya berbagai tanaman serta perawatan satwa baik di kolam maupun kandang', 'water_conservation' => 'Mengolah limbah sekolah, meningkatkan fungsi drainase, meresapkan air hujan di lokasi sekolah', 'canteen_management' => 'Mengurangi sampah plastik di kantin, meningkatkan potensi makana lokal sekolah', 'created_at' => '2020-11-29 04:35:08', 'updated_at' => '2020-11-29 04:35:08')
        );

        if (is_array($quality_reports) && count($quality_reports)) {
            QualityReport::query()->insert($quality_reports);
        }
    }
}
