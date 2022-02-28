<?php

use App\CurriculumCalendar;
use Illuminate\Database\Seeder;

class CurriculumCalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $curriculum_calendars = array(
            array('id' => '1', 'slug' => 'hari-menanam-pohon', 'name' => 'Hari Menanam Pohon', 'created_at' => '2020-04-11 20:26:32', 'updated_at' => '2020-04-11 20:26:32'),
            array('id' => '2', 'slug' => 'hari-peduli-sampah', 'name' => 'Hari Peduli Sampah', 'created_at' => '2020-04-11 20:26:58', 'updated_at' => '2020-04-11 20:26:58'),
            array('id' => '3', 'slug' => 'hari-air', 'name' => 'Hari Air', 'created_at' => '2020-04-11 20:27:24', 'updated_at' => '2020-04-11 20:27:24'),
            array('id' => '4', 'slug' => 'hari-bumi', 'name' => 'Hari Bumi', 'created_at' => '2020-04-11 20:27:41', 'updated_at' => '2020-04-11 20:27:41'),
            array('id' => '5', 'slug' => 'hari-pengurangan-risiko-bencana', 'name' => 'Hari Pengurangan Risiko Bencana', 'created_at' => '2020-04-11 20:28:32', 'updated_at' => '2020-04-11 20:28:32'),
            array('id' => '6', 'slug' => 'hari-keanekaragaman-hayati', 'name' => 'Hari Keanekaragaman Hayati', 'created_at' => '2020-04-11 20:28:56', 'updated_at' => '2020-04-11 20:28:56'),
            array('id' => '7', 'slug' => 'hari-lingkungan-hidup', 'name' => 'Hari Lingkungan Hidup', 'created_at' => '2020-04-11 20:29:11', 'updated_at' => '2020-04-11 20:29:11'),
            array('id' => '8', 'slug' => 'hari-perlindungan-lapisan-ozon', 'name' => 'Hari Perlindungan Lapisan Ozon', 'created_at' => '2020-04-11 20:29:32', 'updated_at' => '2020-04-11 20:29:32'),
            array('id' => '9', 'slug' => 'hari-pangan-sedunia', 'name' => 'Hari Pangan Sedunia', 'created_at' => '2020-04-11 20:29:49', 'updated_at' => '2020-04-11 20:29:49'),
            array('id' => '10', 'slug' => 'hari-cinta-puspa-dan-satwa', 'name' => 'Hari Cinta Puspa dan Satwa', 'created_at' => '2020-04-11 20:30:07', 'updated_at' => '2020-04-11 20:30:07')
        );

        if (is_array($curriculum_calendars) && count($curriculum_calendars)) {
            CurriculumCalendar::query()->insert($curriculum_calendars);
        }
    }
}
