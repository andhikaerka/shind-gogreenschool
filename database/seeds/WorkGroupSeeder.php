<?php

use App\WorkGroup;
use Illuminate\Database\Seeder;

class WorkGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $work_groups = array(
            array('id' => '1', 'school_profile_id' => '1', 'work_group_name_id' => '1', 'alias' => NULL, 'description' => '', 'aspect_id' => '1', 'tutor' => 'Triyana, S.Pd.', 'task' => '1. MEMBUAT PUPUK ORGANIK DARI SAMPAH ORGANIK,
2. MONITORING PRODUKSI KOMPOS
3. MERAWAT PERALATAN DN PERLENGKAPAN
4. MEMBUAT LAPORAN KERJA
5. MENSOSIALISASI KEPADA WARGA SEKOLAH
6. MEMPUBLIKASIKAN KE MASYARAKAT UMUM
7. MENSOSIALISASIKAN KE BEBERAPA MEDIA/PUBLIKASI,
DLL', 'created_at' => '2020-08-04 08:22:50', 'updated_at' => '2020-08-04 08:22:50'),
            array('id' => '2', 'school_profile_id' => '1', 'work_group_name_id' => '2', 'alias' => NULL, 'description' => '', 'aspect_id' => '1', 'tutor' => 'Andiyana , S.Pd', 'task' => 'Membuat kerajinan daur ulang dari sampah an organik', 'created_at' => '2020-08-12 21:45:15', 'updated_at' => '2020-08-12 21:45:15'),
            array('id' => '3', 'school_profile_id' => '1', 'work_group_name_id' => '3', 'alias' => NULL, 'description' => '', 'aspect_id' => '1', 'tutor' => 'Murni S.Pd', 'task' => 'Menjual sampah anorganik deel', 'created_at' => '2020-08-12 21:46:20', 'updated_at' => '2020-08-12 21:46:20'),
            array('id' => '4', 'school_profile_id' => '1', 'work_group_name_id' => '4', 'alias' => NULL, 'description' => '', 'aspect_id' => '2', 'tutor' => 'Wandini, S.Pd', 'task' => 'Gerakan hemat listrik, deel', 'created_at' => '2020-08-12 21:47:50', 'updated_at' => '2020-08-12 21:47:50'),
            array('id' => '5', 'school_profile_id' => '1', 'work_group_name_id' => '9', 'alias' => NULL, 'description' => '', 'aspect_id' => '3', 'tutor' => 'Anjas,S.Pd', 'task' => 'Budidaya Hidroponik , deel', 'created_at' => '2020-08-12 21:49:06', 'updated_at' => '2020-08-12 21:49:06'),
            array('id' => '6', 'school_profile_id' => '1', 'work_group_name_id' => '8', 'alias' => NULL, 'description' => '', 'aspect_id' => '3', 'tutor' => 'Endang, S.Pd', 'task' => 'Menanam obatobatan keluarga, deel', 'created_at' => '2020-08-12 21:50:24', 'updated_at' => '2020-08-12 21:50:24'),
            array('id' => '7', 'school_profile_id' => '1', 'work_group_name_id' => '11', 'alias' => NULL, 'description' => '', 'aspect_id' => '4', 'tutor' => 'Muhamad, S.Pd', 'task' => 'Membuat lubang resapan biopori, S.Pd', 'created_at' => '2020-08-12 21:51:27', 'updated_at' => '2020-08-12 21:51:27'),
            array('id' => '8', 'school_profile_id' => '1', 'work_group_name_id' => '13', 'alias' => NULL, 'description' => '', 'aspect_id' => '4', 'tutor' => 'Saraswati.S.Pd', 'task' => 'Melancarkan pengairan limbah di sekolah, Deel', 'created_at' => '2020-08-12 21:52:40', 'updated_at' => '2020-08-12 21:52:40'),
            array('id' => '9', 'school_profile_id' => '1', 'work_group_name_id' => '15', 'alias' => NULL, 'description' => '', 'aspect_id' => '5', 'tutor' => 'Mularjito,S.Pd', 'task' => 'Mengurangi Sampah Plastik di Kantin', 'created_at' => '2020-08-12 21:54:04', 'updated_at' => '2020-08-12 21:54:04'),
            array('id' => '10', 'school_profile_id' => '1', 'work_group_name_id' => '7', 'alias' => NULL, 'description' => '', 'aspect_id' => '3', 'tutor' => 'Abi Pangestu, S.pd', 'task' => 'Merawat taman dan kola sekolah', 'created_at' => '2020-08-12 21:54:57', 'updated_at' => '2020-08-12 21:54:57'),
            array('id' => '11', 'school_profile_id' => '1', 'work_group_name_id' => '6', 'alias' => NULL, 'description' => '', 'aspect_id' => '2', 'tutor' => 'abi mahendra', 'task' => 'Aksi setiap jumaT', 'created_at' => '2020-10-07 08:23:05', 'updated_at' => '2020-10-07 08:23:05'),
            array('id' => '12', 'school_profile_id' => '1', 'work_group_name_id' => '18', 'alias' => NULL, 'description' => '', 'aspect_id' => '3', 'tutor' => 'Endang', 'task' => 'membersihkan tia[ kamis', 'created_at' => '2020-10-07 08:30:06', 'updated_at' => '2020-10-07 08:30:06'),
            array('id' => '14', 'school_profile_id' => '3', 'work_group_name_id' => '2', 'alias' => NULL, 'description' => 'Membuat kerajinan daur ulang dari barang bekas', 'aspect_id' => '1', 'tutor' => 'Marjiko, Sp.d', 'task' => 'Membuat kerajinan daur ulang dari bahan bekas / sampah anorganik', 'created_at' => '2020-11-28 21:38:24', 'updated_at' => '2020-11-28 21:38:24'),
            array('id' => '15', 'school_profile_id' => '3', 'work_group_name_id' => '1', 'alias' => NULL, 'description' => 'Membuat pupuk kompos dari sampah organik', 'aspect_id' => '1', 'tutor' => 'Wahyuni, S.Pd', 'task' => 'Membuat pupuk kompos dari bahan sampah organik', 'created_at' => '2020-11-28 21:40:11', 'updated_at' => '2020-11-28 21:40:11'),
            array('id' => '16', 'school_profile_id' => '3', 'work_group_name_id' => '3', 'alias' => NULL, 'description' => 'Menjual sampah yang masih produktif', 'aspect_id' => '1', 'tutor' => 'Bambang Sutejo, S.T', 'task' => 'Mengumpulkan ,memilah ,memproses penjualan', 'created_at' => '2020-11-28 21:41:49', 'updated_at' => '2020-11-28 21:41:49'),
            array('id' => '17', 'school_profile_id' => '3', 'work_group_name_id' => '4', 'alias' => NULL, 'description' => 'Mengurangi pembayaran listrik', 'aspect_id' => '2', 'tutor' => 'Wahyu Hariyanto, S.Pd', 'task' => 'Mematikan listrik yang tidak digunakan', 'created_at' => '2020-11-28 21:43:54', 'updated_at' => '2020-11-28 21:43:54'),
            array('id' => '18', 'school_profile_id' => '3', 'work_group_name_id' => '5', 'alias' => NULL, 'description' => 'Mengembangkan energi selain listrik', 'aspect_id' => '2', 'tutor' => 'Budiyono, S,Pd', 'task' => 'Memasang  dan merawat panel surya', 'created_at' => '2020-11-28 21:45:12', 'updated_at' => '2020-11-28 21:45:12'),
            array('id' => '19', 'school_profile_id' => '3', 'work_group_name_id' => '7', 'alias' => NULL, 'description' => 'Merawat tanaman dan kolam', 'aspect_id' => '3', 'tutor' => 'Indah sari, M.Pd', 'task' => 'Menanam dan merawat taman serta kolam', 'created_at' => '2020-11-28 21:47:06', 'updated_at' => '2020-11-28 21:47:06'),
            array('id' => '20', 'school_profile_id' => '3', 'work_group_name_id' => '8', 'alias' => NULL, 'description' => 'Menanam tanaman obat keluarga', 'aspect_id' => '3', 'tutor' => 'Titik warti, S.Pd', 'task' => 'Menanam berbagai tanaman obat untuk keluarga', 'created_at' => '2020-11-28 21:50:37', 'updated_at' => '2020-11-28 21:50:37'),
            array('id' => '21', 'school_profile_id' => '3', 'work_group_name_id' => '13', 'alias' => NULL, 'description' => 'Merawat saluran drainase sekolah', 'aspect_id' => '4', 'tutor' => 'Wardi, S.pd', 'task' => 'Merawat saluran drainase sekolah', 'created_at' => '2020-11-28 21:52:06', 'updated_at' => '2020-11-28 21:52:06'),
            array('id' => '22', 'school_profile_id' => '3', 'work_group_name_id' => '11', 'alias' => NULL, 'description' => 'Membuat lubang resapan air', 'aspect_id' => '4', 'tutor' => 'Endang Murni, Spd', 'task' => 'Membuat lubang resapan air', 'created_at' => '2020-11-28 21:53:17', 'updated_at' => '2020-11-28 21:53:17'),
            array('id' => '23', 'school_profile_id' => '3', 'work_group_name_id' => '15', 'alias' => NULL, 'description' => 'Mengurangi  plastik di kantin', 'aspect_id' => '5', 'tutor' => 'Mardini, S.Pd', 'task' => 'Mengurangi dan mengolah sampah plastik di kantin', 'created_at' => '2020-11-28 21:54:29', 'updated_at' => '2020-11-28 21:54:29')
        );

        /*foreach ($work_groups as $key => $work_group) {
            \App\User::query()->where('id', $work_group['user_id'])->delete();

            $work_groups[$key]['description'] = '';
            unset($work_groups[$key]['user_id']);
        }*/

        if (is_array($work_groups) && count($work_groups)) {
            WorkGroup::query()->insert($work_groups);
        }
    }
}
