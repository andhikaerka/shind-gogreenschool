<?php

use App\Study;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $studies = array(
            array('id' => '1', 'quality_report_id' => '1', 'work_group_id' => '1', 'snp_category_id' => '1', 'potential' => 'BANYAK TANAMAN SEHINGGA SAMPAH ORGANIK MELIMPAH,
MEMILIKI KADER YANG BANYAK, MEMILIKI TONG KOMPOSTER', 'problem' => 'DITENGAH PEMUKIMAN , SAMPAH MASIH BERCAMPUR,
SAMPAH DARI KANTIN MSIH BANYAK, DEEL', 'activity' => 'MEMANEN KOMPOS', 'behavioral' => 'SISWA DAPAT MEMILAH SAMPAH, SISWA DAPAT MEMBUAT PUPUK KOMPOS.', 'physical' => 'SEKOLAH JADI BERSIH ,INDAH,SEHAT', 'kbm' => 'IPA KELAS 8 SEMSERTER GENAP, AGAMA KELAS 7 SEMSETER 1', 'artwork' => 'PUPUK ORGANIK', 'period' => '15', 'source' => 'BOS', 'cost' => '2900000', 'percentage' => '13', 'partner_id' => '1', 'created_at' => '2020-08-04 14:02:28', 'updated_at' => '2020-08-17 16:22:37'),
            array('id' => '2', 'quality_report_id' => '1', 'work_group_id' => '3', 'snp_category_id' => '1', 'potential' => 'Siswa banyak', 'problem' => 'Banyak sampah Plastik', 'activity' => NULL, 'behavioral' => 'dapat memilah sampah', 'physical' => 'sekolah bersih', 'kbm' => 'ipa', 'artwork' => 'memiliki bank sampah', 'period' => '3', 'source' => 'BOS', 'cost' => '600000', 'percentage' => '15', 'partner_id' => '1', 'created_at' => '2020-08-12 22:20:09', 'updated_at' => '2020-08-12 22:20:09'),
            array('id' => '3', 'quality_report_id' => '1', 'work_group_id' => '4', 'snp_category_id' => '1', 'potential' => 'Daya listrik besar', 'problem' => 'Lampu tidak dimatikan', 'activity' => 'yes', 'behavioral' => 'sadar mematikan listrik yg tidak digunakan dll', 'physical' => 'Lampu dan peralatan elektronik  jadi awet', 'kbm' => 'fisika', 'artwork' => 'stiker', 'period' => '5', 'source' => 'BOS NAS', 'cost' => '300000', 'percentage' => '16', 'partner_id' => '1', 'created_at' => '2020-08-12 22:23:10', 'updated_at' => '2020-08-17 16:37:20'),
            array('id' => '4', 'quality_report_id' => '1', 'work_group_id' => '5', 'snp_category_id' => '1', 'potential' => 'Kantin banyak pembeli', 'problem' => 'Kurang sayur', 'activity' => NULL, 'behavioral' => 'punya sayuran sendiri', 'physical' => 'ada bangunan greenhouse', 'kbm' => 'biologi', 'artwork' => 'tanaman hidroponik', 'period' => '4', 'source' => 'Komite', 'cost' => '450000', 'percentage' => '5', 'partner_id' => '1', 'created_at' => '2020-08-12 22:25:48', 'updated_at' => '2020-08-12 22:25:48'),
            array('id' => '5', 'quality_report_id' => '1', 'work_group_id' => '8', 'snp_category_id' => '1', 'potential' => 'Lahan luas', 'problem' => 'Banjir', 'activity' => 'baik', 'behavioral' => 'tidak ada genangan air', 'physical' => 'saluran drainase lancar', 'kbm' => 'pkn', 'artwork' => 'foto dan poster', 'period' => '6', 'source' => 'Komite', 'cost' => '700000', 'percentage' => '10', 'partner_id' => '1', 'created_at' => '2020-08-12 22:27:42', 'updated_at' => '2020-08-17 16:24:45'),
            array('id' => '6', 'quality_report_id' => '1', 'work_group_id' => '9', 'snp_category_id' => '1', 'potential' => 'siswa banyak', 'problem' => 'kantin sempit banyak sampah', 'activity' => 'ok', 'behavioral' => 'pengurangan kemasan plastik', 'physical' => 'tidak ada kemasan makanan plastik pabrikan', 'kbm' => 'ipa', 'artwork' => 'poster', 'period' => '5', 'source' => 'BOS NAS', 'cost' => '650000', 'percentage' => '12', 'partner_id' => '1', 'created_at' => '2020-08-12 22:31:16', 'updated_at' => '2020-08-17 16:36:13'),
            array('id' => '7', 'quality_report_id' => '1', 'work_group_id' => '4', 'snp_category_id' => '1', 'potential' => 'Panas sinar matahari', 'problem' => 'Terlalu banyak daya terpakai', 'activity' => NULL, 'behavioral' => 'Hemat energi setiap warga sekolah', 'physical' => 'Lampu tidak mati', 'kbm' => 'Bahasa jawa', 'artwork' => 'Lampu Jalan', 'period' => '6', 'source' => 'Sponsor', 'cost' => '700000', 'percentage' => '12', 'partner_id' => '2', 'created_at' => '2020-08-17 16:47:49', 'updated_at' => '2020-08-17 16:47:49'),
            array('id' => '8', 'quality_report_id' => '1', 'work_group_id' => '2', 'snp_category_id' => '1', 'potential' => 'Banyak SDM Kreatif', 'problem' => 'Banyak sisa baraang sampah yang tidak dipakai', 'activity' => 'Membbuat baju  daur ulang', 'behavioral' => 'menghargai sampah', 'physical' => 'Sekolah lebih bersih', 'kbm' => 'Bahasa Indonesia', 'artwork' => 'Baju daur ulang', 'period' => '5', 'source' => 'Komite', 'cost' => '980000', 'percentage' => '7', 'partner_id' => '1', 'created_at' => '2020-08-17 16:52:31', 'updated_at' => '2020-08-17 16:52:31'),
            array('id' => '9', 'quality_report_id' => '1', 'work_group_id' => '2', 'snp_category_id' => '1', 'potential' => 'Banyak bahan', 'problem' => 'Kotor', 'activity' => NULL, 'behavioral' => 'diet plastik ok', 'physical' => 'sekolah bebas plastik', 'kbm' => 'PKn', 'artwork' => 'baju daur ulang', 'period' => '10', 'source' => 'Komite', 'cost' => '769000', 'percentage' => '5', 'partner_id' => '2', 'created_at' => '2020-08-17 17:03:17', 'updated_at' => '2020-08-17 17:03:17'),
            array('id' => '10', 'quality_report_id' => '1', 'work_group_id' => '10', 'snp_category_id' => '1', 'potential' => 'Memiliki gedung yang besar', 'problem' => 'Ruang terbuka hijau sempit', 'activity' => 'Konservasi burung hantu', 'behavioral' => 'Warga sekolah cinta satwa dan mengenal satwa yang dilindungi', 'physical' => 'Menambah keindahan dan keberagaman hayati di skeolah', 'kbm' => 'Biologi', 'artwork' => 'Poster cinta satwa, laporan penamatan dll', 'period' => '10', 'source' => 'Sponsor', 'cost' => '649996', 'percentage' => '3', 'partner_id' => '6', 'created_at' => '2020-08-18 06:59:11', 'updated_at' => '2020-08-18 06:59:11'),
            array('id' => '11', 'quality_report_id' => '1', 'work_group_id' => '9', 'snp_category_id' => '1', 'potential' => 'Siswa banyak', 'problem' => 'Kantin kecil', 'activity' => 'Membuat kantin baru', 'behavioral' => 'Siswa tertib di Kantin', 'physical' => 'Kelas tidak ada sampah dari kantin', 'kbm' => 'PKN', 'artwork' => 'Laporan dan wawancara', 'period' => '5', 'source' => 'Komite', 'cost' => '700000', 'percentage' => '2', 'partner_id' => '1', 'created_at' => '2020-08-18 07:05:01', 'updated_at' => '2020-08-18 07:05:01')
        );

        if (is_array($studies) && count($studies)) {
            Study::query()->insert($studies);
        }
    }
}
