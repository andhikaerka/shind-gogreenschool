<?php

use App\SchoolProfile;
use Illuminate\Database\Seeder;

class SchoolProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $school_profiles = array(
            array('id' => '1', 'school_id' => '1', 'year' => '2020', 'environmental_status_id' => '2', 'vision' => 'Berbudaya dan Cinta Lingkungan', 'total_students' => '8', 'total_teachers' => '57', 'total_land_area' => '7000', 'total_building_area' => '1996', 'created_at' => '2020-08-04 07:54:39', 'updated_at' => '2020-11-27 01:07:03'),
            array('id' => '2', 'school_id' => '2', 'year' => '2020', 'environmental_status_id' => '1', 'vision' => 'Beriman, Berilmu, Berkarakter, dan Berbudaya Lingkungan', 'total_students' => '650', 'total_teachers' => '48', 'total_land_area' => '5777', 'total_building_area' => '3900', 'created_at' => '2020-08-25 10:52:17', 'updated_at' => '2020-11-18 08:12:12'),
            array('id' => '3', 'school_id' => '3', 'year' => '2020', 'environmental_status_id' => '1', 'vision' => 'Berakhlaq mulia, cerdas dan peduli lingkungan hidup', 'total_students' => '460', 'total_teachers' => '30', 'total_land_area' => '3898', 'total_building_area' => '2100', 'created_at' => '2020-11-18 10:25:19', 'updated_at' => '2020-11-18 11:17:51'),
            array('id' => '4', 'school_id' => '4', 'year' => '2020', 'environmental_status_id' => '4', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-18 16:02:22', 'updated_at' => '2020-11-18 16:02:22'),
            array('id' => '5', 'school_id' => '5', 'year' => '2020', 'environmental_status_id' => '4', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-18 16:13:41', 'updated_at' => '2020-11-18 16:13:41'),
            array('id' => '6', 'school_id' => '6', 'year' => '2020', 'environmental_status_id' => '3', 'vision' => 'Unggul Dalam Prestasi, Berakhlak Mulia, Berkarakter, Berbudaya, dan Berwawasan
Lingkungan', 'total_students' => '700', 'total_teachers' => '47', 'total_land_area' => '6000', 'total_building_area' => '4000', 'created_at' => '2020-11-18 22:04:48', 'updated_at' => '2020-11-26 20:32:39'),
            array('id' => '7', 'school_id' => '7', 'year' => '2020', 'environmental_status_id' => '3', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-18 22:08:21', 'updated_at' => '2020-11-18 22:08:21'),
            array('id' => '8', 'school_id' => '8', 'year' => '2020', 'environmental_status_id' => '3', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 13:07:39', 'updated_at' => '2020-11-19 13:07:39'),
            array('id' => '9', 'school_id' => '9', 'year' => '2020', 'environmental_status_id' => '2', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 13:56:37', 'updated_at' => '2020-11-19 13:56:37'),
            array('id' => '10', 'school_id' => '10', 'year' => '2020', 'environmental_status_id' => '2', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 13:58:38', 'updated_at' => '2020-11-19 13:58:38'),
            array('id' => '11', 'school_id' => '11', 'year' => '2020', 'environmental_status_id' => '2', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 13:59:13', 'updated_at' => '2020-11-19 13:59:13'),
            array('id' => '12', 'school_id' => '12', 'year' => '2020', 'environmental_status_id' => '4', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 13:59:19', 'updated_at' => '2020-11-19 13:59:19'),
            array('id' => '13', 'school_id' => '13', 'year' => '2020', 'environmental_status_id' => '5', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 13:59:39', 'updated_at' => '2020-11-19 13:59:39'),
            array('id' => '14', 'school_id' => '14', 'year' => '2020', 'environmental_status_id' => '4', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 13:59:50', 'updated_at' => '2020-11-19 13:59:50'),
            array('id' => '15', 'school_id' => '15', 'year' => '2020', 'environmental_status_id' => '4', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 14:00:50', 'updated_at' => '2020-11-19 14:00:50'),
            array('id' => '16', 'school_id' => '16', 'year' => '2020', 'environmental_status_id' => '2', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 14:00:56', 'updated_at' => '2020-11-19 14:00:56'),
            array('id' => '17', 'school_id' => '17', 'year' => '2020', 'environmental_status_id' => '4', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 14:01:29', 'updated_at' => '2020-11-19 14:01:29'),
            array('id' => '18', 'school_id' => '18', 'year' => '2020', 'environmental_status_id' => '1', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 14:02:15', 'updated_at' => '2020-11-19 14:02:15'),
            array('id' => '19', 'school_id' => '19', 'year' => '2020', 'environmental_status_id' => '4', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 14:03:17', 'updated_at' => '2020-11-19 14:03:17'),
            array('id' => '20', 'school_id' => '20', 'year' => '2020', 'environmental_status_id' => '1', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-19 14:06:46', 'updated_at' => '2020-11-19 14:06:46'),
            array('id' => '21', 'school_id' => '21', 'year' => '2020', 'environmental_status_id' => '3', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-20 08:38:34', 'updated_at' => '2020-11-20 08:38:34'),
            array('id' => '22', 'school_id' => '2', 'year' => '2019', 'environmental_status_id' => '1', 'vision' => 'Beriman, Berilmu, Berkarakter, dan Berbudaya Lingkungan', 'total_students' => '650', 'total_teachers' => '48', 'total_land_area' => '5777', 'total_building_area' => '3900', 'created_at' => '2020-11-20 11:01:03', 'updated_at' => '2020-11-20 11:01:03'),
            array('id' => '23', 'school_id' => '22', 'year' => '2020', 'environmental_status_id' => '3', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-21 10:15:30', 'updated_at' => '2020-11-21 10:15:30'),
            array('id' => '24', 'school_id' => '23', 'year' => '2020', 'environmental_status_id' => '2', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-25 04:46:49', 'updated_at' => '2020-11-25 04:46:49'),
            array('id' => '25', 'school_id' => '24', 'year' => '2020', 'environmental_status_id' => '2', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-26 12:07:22', 'updated_at' => '2020-11-26 12:07:22'),
            array('id' => '26', 'school_id' => '25', 'year' => '2020', 'environmental_status_id' => '1', 'vision' => 'Sekolah ramah anak peduli lingkungan hidup', 'total_students' => '210', 'total_teachers' => '13', 'total_land_area' => '998', 'total_building_area' => '700', 'created_at' => '2020-11-27 07:54:33', 'updated_at' => '2020-11-27 09:06:43'),
            array('id' => '27', 'school_id' => '26', 'year' => '2020', 'environmental_status_id' => '4', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-27 08:17:15', 'updated_at' => '2020-11-27 08:17:15'),
            array('id' => '28', 'school_id' => '27', 'year' => '2020', 'environmental_status_id' => '2', 'vision' => '', 'total_students' => '0', 'total_teachers' => '0', 'total_land_area' => '0', 'total_building_area' => '0', 'created_at' => '2020-11-30 10:45:37', 'updated_at' => '2020-11-30 10:45:37')
        );

        if (is_array($school_profiles) && count($school_profiles)) {
            SchoolProfile::query()->insert($school_profiles);
        }
    }
}
