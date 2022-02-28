<?php

use App\WorkProgram;
use Illuminate\Database\Seeder;

class WorkProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $work_programs = array(
            array('id' => '1', 'name' => 'Komposter', 'study_id' => '1', 'condition' => 'TIDAK AKTIF KARENA TIDAK ADA KEGIATAN PENGOMPOSAN,
ALAT PERLU DIPERBAIKI,BUTUH AKTIFATOR,BUTUH
PERAL', 'plan' => 'MEMBERSIHKAN LAHAN,MEMBUAT PIKET KERJA.
MELAKUKAN PEMILAHAN.PRODUKSI KOMPOS
PANEN KOPOS.FINALIASAI P', 'percentage' => '11', 'time' => '9', 'tutor_1' => 'Andiyana , S.Pd', 'tutor_2' => 'IBU. MAYA ANGGINI , M.PD', 'tutor_3' => 'BP. AGUS SUBAGYO, S.PD', 'featured' => '1', 'created_at' => '2020-08-04 14:42:30', 'updated_at' => '2020-11-26 07:22:25'),
            array('id' => '2', 'name' => 'Panel Surya', 'study_id' => '3', 'condition' => 'cukup baik', 'plan' => 'membuat pompa hidroponik', 'percentage' => '6', 'time' => '11', 'tutor_1' => 'Triyana, S.Pd.', 'tutor_2' => 'Aditya nur hadi', 'tutor_3' => 'mardiani', 'featured' => '1', 'created_at' => '2020-08-17 15:50:22', 'updated_at' => '2020-08-22 15:45:32'),
            array('id' => '3', 'name' => 'Membuat busana daur ulang', 'study_id' => '8', 'condition' => 'perlu perbaikan', 'plan' => 'pelatihan', 'percentage' => '6', 'time' => '8', 'tutor_1' => 'Anjas,S.Pd', 'tutor_2' => 'Sudirja', 'tutor_3' => 'mashuri', 'featured' => '0', 'created_at' => '2020-08-17 17:06:43', 'updated_at' => '2020-08-17 17:06:43'),
            array('id' => '4', 'name' => 'Panel Surya 2', 'study_id' => '3', 'condition' => 'Tidak maksimal', 'plan' => 'Melengkapi lampu
membuat jadwal
membuat laporan audit', 'percentage' => '2', 'time' => '9', 'tutor_1' => 'Wandini, S.Pd', 'tutor_2' => 'Sudirja', 'tutor_3' => 'mashuri', 'featured' => '1', 'created_at' => '2020-08-18 07:12:10', 'updated_at' => '2020-08-22 15:50:12'),
            array('id' => '5', 'name' => 'Panel Surya', 'study_id' => '3', 'condition' => 'Tidak ad stiker matikan listrik', 'plan' => 'Membat stiker hemat energi', 'percentage' => '10', 'time' => '4', 'tutor_1' => 'Triyana, S.Pd.', 'tutor_2' => 'Sudirja', 'tutor_3' => 'nubaii', 'featured' => '1', 'created_at' => '2020-08-18 07:59:30', 'updated_at' => '2020-08-18 07:59:30'),
            array('id' => '6', 'name' => 'Mengganti lampu LED', 'study_id' => '3', 'condition' => 'Banyak lampu lama yang menyerap daya tinggi', 'plan' => 'Mengganti lampu LED Bertahap', 'percentage' => '4', 'time' => '10', 'tutor_1' => 'Andiyana , S.Pd', 'tutor_2' => 'Subarjo,S.Pd', 'tutor_3' => 'rusmoto', 'featured' => '1', 'created_at' => '2020-08-18 08:05:48', 'updated_at' => '2020-08-22 15:46:14'),
            array('id' => '7', 'name' => 'Sosialisasi Bank Sampah online', 'study_id' => '2', 'condition' => 'Perlu lokasi khusus untuk bank sampah', 'plan' => 'Memberihkan ruang osis', 'percentage' => '5', 'time' => '4', 'tutor_1' => 'Murni S.Pd', 'tutor_2' => 'Sudirja', 'tutor_3' => 'Mustofa', 'featured' => '0', 'created_at' => '2020-08-22 15:52:09', 'updated_at' => '2020-08-22 15:52:09'),
            array('id' => '8', 'name' => 'membuat gorong2', 'study_id' => '5', 'condition' => 'rusak semua, air limbah bocor', 'plan' => '1. membuat denah
2. mencari tukang
3. membeli matrerial
4. pengerjaan
5. piket perawatan', 'percentage' => '35', 'time' => '2', 'tutor_1' => 'Murni S.Pd', 'tutor_2' => 'Supriyadi, S.Pd', 'tutor_3' => 'Mustofa', 'featured' => '0', 'created_at' => '2020-10-07 08:50:02', 'updated_at' => '2020-10-07 08:50:02'),
            array('id' => '9', 'name' => 'Pameran hasil kompos', 'study_id' => '1', 'condition' => 'Kurang baik, banyak perlengkapan tidak ada, komposter rusak pipa-pipanyanya', 'plan' => 'Membeli perlengkapan dan membetulkan pipa pipa di komposter', 'percentage' => '10', 'time' => '2', 'tutor_1' => 'Triyana, S.Pd.', 'tutor_2' => 'Sudirja', 'tutor_3' => 'Ahmad parlan', 'featured' => '1', 'created_at' => '2020-11-23 05:06:53', 'updated_at' => '2020-11-23 05:06:53')
        );

        if (is_array($work_programs) && count($work_programs)) {
            WorkProgram::query()->insert($work_programs);
        }
    }
}
