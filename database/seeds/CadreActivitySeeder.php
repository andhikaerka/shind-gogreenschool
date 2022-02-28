<?php

use App\CadreActivity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CadreActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cadre_activities = array(
            array('id' => '1', 'date' => '2020-08-17', 'work_program_id' => '1', 'condition' => '1', 'percentage' => '10', 'results' => 'PERALATAN SUDAH SIAP,TONG KOMPOS ADA 4, SEDANG DI BUATAN TEMPAT AGAR TIDAK TERKENA HUJAN DAN PANAS.', 'problem' => 'LOKASI UNTUK TEMPAT KOMPOS YANG SESUAI BELM DIDAPAT', 'behavioral' => 'KADER SISWA DAN KETUA KELAS SUDAH MENGETAHUI CARA KOMPOSTING', 'physical' => 'SAMPAH MULAI DIPILAH', 'plan' => 'MEMBENTUK JADWAL PIKET DAN MULAI PRODUKSI', 'created_at' => '2020-08-04 20:03:43', 'updated_at' => '2020-08-04 20:03:43'),
            array('id' => '2', 'date' => '2020-08-12', 'work_program_id' => '4', 'condition' => '1', 'percentage' => '10', 'results' => 'Mendata lampu dan peralatan listrik di sekolah', 'problem' => 'Ruang tertentu dan peralatan elektronika yang terlalu lama', 'behavioral' => 'Warga sekolah lebih hemat dan peduli listrik', 'physical' => 'Tertata rapi dan pengurangan pembayaran listrik', 'plan' => 'Membentuk polisi listrik', 'created_at' => '2020-08-18 16:42:35', 'updated_at' => '2020-08-18 16:42:35'),
            array('id' => '3', 'date' => '2020-07-28', 'work_program_id' => '5', 'condition' => '2', 'percentage' => '25', 'results' => 'bagus', 'problem' => 'ada sih', 'behavioral' => 'ok', 'physical' => 'jg', 'plan' => 'sama', 'created_at' => '2020-08-18 20:16:45', 'updated_at' => '2020-08-18 20:16:45'),
            array('id' => '4', 'date' => '2020-08-07', 'work_program_id' => '3', 'condition' => '1', 'percentage' => '10', 'results' => 'bagus', 'problem' => 'tidak ada teman', 'behavioral' => 'maju terus', 'physical' => 'bersih semua', 'plan' => 'mencari teman', 'created_at' => '2020-08-18 20:18:19', 'updated_at' => '2020-08-29 12:01:22'),
            array('id' => '5', 'date' => '2020-07-28', 'work_program_id' => '4', 'condition' => '3', 'percentage' => '30', 'results' => 'ok coba', 'problem' => 'waduh coba', 'behavioral' => 'coba coba', 'physical' => 'coba lagi', 'plan' => 'lagi lagi sobi', 'created_at' => '2020-08-29 12:03:47', 'updated_at' => '2020-08-29 12:03:47'),
            array('id' => '6', 'date' => '2020-09-16', 'work_program_id' => '6', 'condition' => '1', 'percentage' => '10', 'results' => 'Kampanye hari ozon tgl 16 September 2020', 'problem' => 'Masih minim pengetahuan tentang ozon dan dampak bahayanya', 'behavioral' => 'Hemat listrik', 'physical' => 'Memasang lampu LED', 'plan' => 'setiap kelas membuat poster', 'created_at' => '2020-09-17 05:19:54', 'updated_at' => '2020-09-17 05:19:54'),
            array('id' => '7', 'date' => '2020-10-05', 'work_program_id' => '8', 'condition' => '1', 'percentage' => '10', 'results' => 'membuat gorong2', 'problem' => 'pengerejaan dimusim penghhujan', 'behavioral' => 'warga sekolah tidak membuang sampah di gorong2', 'physical' => 'gorong2 barfu hampir jadi', 'plan' => 'dikerjakan kembali setelah hujan mereda', 'created_at' => '2020-10-07 08:56:40', 'updated_at' => '2020-10-07 08:56:40'),
            array('id' => '8', 'date' => '2020-10-10', 'work_program_id' => '8', 'condition' => '2', 'percentage' => '25', 'results' => 'Membersihkan saluaran air sekolah
Memasang bus beton untuk saluran keluar sekolah', 'problem' => 'Pandemi Covid tidak bisa melibatkan langsung siswa', 'behavioral' => 'Lebih  tahu menyelesaikan masalah lingkungan khususnya hemat air', 'physical' => 'Mengurangi genangan air', 'plan' => 'Memetakan denah saluran air yang masih rusak', 'created_at' => '2020-11-21 02:27:22', 'updated_at' => '2020-11-21 02:27:22'),
            array('id' => '9', 'date' => '2020-11-24', 'work_program_id' => '2', 'condition' => '2', 'percentage' => '25', 'results' => 'Bikin poster dan pesan hemat energi', 'problem' => 'Corona belm bisa ketemu siswa lainnya', 'behavioral' => 'Siswa mengetahui hemat energi', 'physical' => 'Peralatan elektonik dan lampu lbh awet terawat', 'plan' => 'Meningkatkan jadwal kerja siswa', 'created_at' => '2020-11-24 07:37:21', 'updated_at' => '2020-11-24 07:37:21')
        );

        if (is_array($cadre_activities) && count($cadre_activities)) {
            CadreActivity::query()->insert($cadre_activities);
        }
    }
}
