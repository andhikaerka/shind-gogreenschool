<?php

use App\WorkGroupName;
use Illuminate\Database\Seeder;

class WorkGroupNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $work_group_names = array(
            array('id' => '1', 'slug' => 'komposting', 'name' => 'Komposting', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '2', 'slug' => 'daur-ulang-sampah', 'name' => 'Daur Ulang Sampah', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '3', 'slug' => 'bank-sampah', 'name' => 'Bank Sampah', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '4', 'slug' => 'hemat-listrik', 'name' => 'Hemat Listrik', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '5', 'slug' => 'energi-terbarukan', 'name' => 'Energi Terbarukan', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '6', 'slug' => 'engine-off', 'name' => 'Engine Off', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '7', 'slug' => 'taman-kolam', 'name' => 'Taman & Kolam', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '8', 'slug' => 'toga', 'name' => 'Toga', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '9', 'slug' => 'greenhouse', 'name' => 'Greenhouse', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '10', 'slug' => 'sanitasi-lingkungan', 'name' => 'Sanitasi Lingkungan', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '11', 'slug' => 'biopori', 'name' => 'Biopori', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '12', 'slug' => 'sumur-resapan', 'name' => 'Sumur Resapan', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '13', 'slug' => 'drainase-sekolah', 'name' => 'Drainase Sekolah', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '14', 'slug' => 'reduce-plastik-kantin', 'name' => 'Reduce Plastik Kantin', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '15', 'slug' => 'sampah-kantin', 'name' => 'Sampah Kantin', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '16', 'slug' => 'kantin-aman', 'name' => 'Kantin Aman', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '17', 'slug' => 'kantin-bergizi', 'name' => 'Kantin Bergizi', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '18', 'slug' => 'Kebun dan Hutan Sekolah', 'name' => 'Kebun dan Hutan Sekolah', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '19', 'slug' => 'Cinta Satwa', 'name' => 'Cinta Satwa', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '20', 'slug' => 'Bijak Plastik Kantin', 'name' => 'Bijak Plastik Kantin', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '21', 'slug' => 'Makanan B2SA ramah LH', 'name' => 'Makanan B2SA ramah LH', 'created_at' => NULL, 'updated_at' => NULL)
        );

        if (is_array($work_group_names) && count($work_group_names)) {
            WorkGroupName::query()->insert($work_group_names);
        }
    }
}
