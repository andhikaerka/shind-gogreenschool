<?php

use App\TeamStatus;
use Illuminate\Database\Seeder;

class TeamStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team_statuses = array(
            array('id' => '1', 'slug' => 'kepala-sekolah', 'name' => 'Kepala Sekolah', 'created_at' => '2020-04-11 20:23:54', 'updated_at' => '2020-04-11 20:23:54'),
            array('id' => '2', 'slug' => 'komite-sekolah', 'name' => 'Komite Sekolah', 'created_at' => '2020-04-11 20:24:10', 'updated_at' => '2020-04-11 20:24:10'),
            array('id' => '3', 'slug' => 'guru-staf', 'name' => 'Guru/Staf', 'created_at' => '2020-04-11 20:24:19', 'updated_at' => '2020-04-11 20:24:19'),
            array('id' => '4', 'slug' => 'siswa', 'name' => 'Siswa', 'created_at' => '2020-04-11 20:24:31', 'updated_at' => '2020-04-11 20:24:31'),
            array('id' => '5', 'slug' => 'kader-adiwiyata', 'name' => 'Kader Adiwiyata', 'created_at' => '2020-04-11 20:24:39', 'updated_at' => '2020-04-11 20:24:39'),
            array('id' => '6', 'slug' => 'tokoh-masyarakat', 'name' => 'Tokoh Masyarakat', 'created_at' => '2020-04-11 20:24:46', 'updated_at' => '2020-04-11 20:24:46'),
            array('id' => '7', 'slug' => 'petugas-kebersihan', 'name' => 'Petugas Kebersihan', 'created_at' => '2020-04-11 20:24:46', 'updated_at' => '2020-04-11 20:24:46'),
            array('id' => '8', 'slug' => 'petugas-keamanan', 'name' => 'Petugas Keamanan', 'created_at' => '2020-04-11 20:24:46', 'updated_at' => '2020-04-11 20:24:46'),
            array('id' => '9', 'slug' => 'penjaga-sekolah', 'name' => 'Penjaga Sekolah', 'created_at' => '2020-04-11 20:24:46', 'updated_at' => '2020-04-11 20:24:46'),
            array('id' => '10', 'slug' => 'orang-tua-paguyuban', 'name' => 'Orang tua/Paguyuban', 'created_at' => '2020-04-11 20:24:46', 'updated_at' => '2020-04-11 20:24:46'),
            array('id' => '11', 'slug' => 'pihak-mitra-lainnya', 'name' => 'Pihak Mitra Lainnya', 'created_at' => '2020-04-11 20:24:46', 'updated_at' => '2020-04-11 20:24:46'),
            array('id' => '12', 'slug' => 'dewan-pendidikan', 'name' => 'Dewan Pendidikan', 'created_at' => '2020-04-11 20:24:46', 'updated_at' => '2020-04-11 20:24:46')
        );

        if (is_array($team_statuses) && count($team_statuses)) {
            TeamStatus::query()->insert($team_statuses);
        }
    }
}
