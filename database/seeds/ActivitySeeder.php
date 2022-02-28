<?php

use App\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activities = array(
            array('id' => '1', 'name' => 'BIMTEK KOMPOS', 'date' => '2020-04-22', 'work_group_id' => '1', 'activity' => 'PELATIHAN MEMBUAT KOMPOS ORGANIK', 'advantage' => 'MENINGKATKAN PENGETAHUAN KOMPOSTING', 'behavioral' => 'KADER LEBIH PANDAI PRODUKSI KOMPOS', 'physical' => 'PENANGANAN KOMPOSTING LEBIH CEPAT DAN BERSIH', 'tutor' => 'IBU. SARASWATI, S.PD
IBU. MAYA ANGGINI , M.PD
BP. AGUS SUBAGYO, S.PD', 'created_at' => '2020-08-04 20:06:59', 'updated_at' => '2020-08-04 20:13:09'),
            array('id' => '2', 'name' => 'Pelatihan stek batang tanaman', 'date' => '2020-08-05', 'work_group_id' => '10', 'activity' => 'Pelatihan membuat stek batang tumbuh di tanaman buah', 'advantage' => 'Dapat mengembangkan budidaya tanaman buah buahan di sekolah', 'behavioral' => 'Siswa dapat mengenal berbagai tanaman buah buahan di Indoensia', 'physical' => 'Koleksi tanaman buah buahan semakin lengkap', 'tutor' => 'Nurhayati, S.Pd', 'created_at' => '2020-08-22 15:20:03', 'updated_at' => '2020-08-22 15:20:03'),
            array('id' => '3', 'name' => 'Bimtek Adiwiyata', 'date' => '2020-08-10', 'work_group_id' => '2', 'activity' => 'Pembelajaran Konsep Adiwiyata khususnya pengelolaan daur ulang sampah', 'advantage' => 'Menambah pengetahuan guru', 'behavioral' => 'Bisa mendaur ulang sampah an organik yang terbuang', 'physical' => 'Sekolah jadi lebi bersih', 'tutor' => 'Rusmayawati, S.Pd', 'created_at' => '2020-08-22 15:22:39', 'updated_at' => '2020-08-22 15:22:39'),
            array('id' => '4', 'name' => 'Peringatan Hari Peduli Sampah', 'date' => '2020-08-12', 'work_group_id' => '3', 'activity' => 'Deklarasi Bank Sampah Sekolah Online', 'advantage' => 'Administrasi bank sampah lebih tertib', 'behavioral' => 'Sampah tertangani dengan administratif', 'physical' => 'Sekolah jadi bersih bebas sampah', 'tutor' => 'Rusmanto, S.Pd', 'created_at' => '2020-08-22 15:24:38', 'updated_at' => '2020-08-22 15:24:38'),
            array('id' => '5', 'name' => 'Peringatan Hari lingkunga hidup', 'date' => '2020-08-13', 'work_group_id' => '8', 'activity' => 'Gerakan membersihkan bantaran sungai dari sampah', 'advantage' => 'Menambah portopolio kegiatan', 'behavioral' => 'Mengenal lingkungan', 'physical' => 'Menduplikasi di sekolah', 'tutor' => 'Ida, S.Pd', 'created_at' => '2020-08-22 15:27:26', 'updated_at' => '2020-08-22 15:27:26'),
            array('id' => '6', 'name' => 'Peringatan Hari Ozon', 'date' => '2020-08-16', 'work_group_id' => '4', 'activity' => 'Car free day', 'advantage' => 'Menambah portopolio', 'behavioral' => 'Mengenal hari ozon cinta lingkungan', 'physical' => 'Kwalitas udara se makin baik', 'tutor' => 'Trimo harjo', 'created_at' => '2020-08-22 15:31:14', 'updated_at' => '2020-08-22 15:31:14')
        );

        if (is_array($activities) && count($activities)) {
            Activity::query()->insert($activities);
        }
    }
}
