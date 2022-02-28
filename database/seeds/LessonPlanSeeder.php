<?php

use App\LessonPlan;
use Illuminate\Database\Seeder;

class LessonPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lesson_plans = array(
            array('id' => '1', 'school_profile_id' => '1', 'subject' => 'IPA', 'teacher' => 'SURTINAH, S.PD', 'class' => '8', 'period' => '2', 'aspect_id' => '1', 'hook' => 'SISWA MENGETAHUI ARTI PENTINGNYA PEDULI LINGKUNGAN', 'artwork' => 'KOMPOS', 'hour' => '4', 'created_at' => '2020-08-04 14:07:15', 'updated_at' => '2020-08-04 14:07:15'),
            array('id' => '2', 'school_profile_id' => '1', 'subject' => 'IPA', 'teacher' => 'Warsito, S.Pd', 'class' => '7', 'period' => '1', 'aspect_id' => '1', 'hook' => 'Membuat Kompos', 'artwork' => 'Kompos', 'hour' => '2', 'created_at' => '2020-08-12 22:35:19', 'updated_at' => '2020-08-12 22:35:19'),
            array('id' => '3', 'school_profile_id' => '1', 'subject' => 'IPS', 'teacher' => 'Indra', 'class' => '8', 'period' => '2', 'aspect_id' => '2', 'hook' => 'Hemat energi', 'artwork' => 'Poster', 'hour' => '3', 'created_at' => '2020-08-12 22:36:57', 'updated_at' => '2020-08-12 22:36:57'),
            array('id' => '4', 'school_profile_id' => '1', 'subject' => 'Biologi', 'teacher' => 'Indra', 'class' => '7', 'period' => '2', 'aspect_id' => '4', 'hook' => 'Mengenal tatakelola air dalam dan permukaan', 'artwork' => 'Poster', 'hour' => '7', 'created_at' => '2020-08-22 11:31:13', 'updated_at' => '2020-08-22 11:31:13'),
            array('id' => '5', 'school_profile_id' => '1', 'subject' => 'Bahasa Jawa', 'teacher' => 'Riptono', 'class' => '8', 'period' => '1', 'aspect_id' => '2', 'hook' => 'Hemat energi selamatkan bumi', 'artwork' => 'Membuat sajak berbahasa jawa dengan tema hemat energi', 'hour' => '4', 'created_at' => '2020-08-28 05:43:09', 'updated_at' => '2020-08-28 05:43:09'),
            array('id' => '6', 'school_profile_id' => '1', 'subject' => 'Bhs Indonesia', 'teacher' => 'Maryati', 'class' => '8', 'period' => '2', 'aspect_id' => '3', 'hook' => 'Mengetahui nama tanaman', 'artwork' => 'Poster', 'hour' => '4', 'created_at' => '2020-08-28 13:32:51', 'updated_at' => '2020-08-28 13:32:51'),
            array('id' => '7', 'school_profile_id' => '1', 'subject' => 'IPS', 'teacher' => 'Anjani', 'class' => '8', 'period' => '1', 'aspect_id' => '1', 'hook' => 'Mengenal sampah', 'artwork' => 'Kompos', 'hour' => '3', 'created_at' => '2020-08-28 13:34:06', 'updated_at' => '2020-08-28 13:34:06'),
            array('id' => '8', 'school_profile_id' => '1', 'subject' => 'PKN', 'teacher' => 'Sarjino', 'class' => '7', 'period' => '1', 'aspect_id' => '2', 'hook' => 'Mikro hidro', 'artwork' => 'Peraga mikro hidro', 'hour' => '4', 'created_at' => '2020-08-28 13:35:24', 'updated_at' => '2020-08-28 13:35:24'),
            array('id' => '9', 'school_profile_id' => '1', 'subject' => 'Matematika', 'teacher' => 'Rusman', 'class' => '8', 'period' => '2', 'aspect_id' => '1', 'hook' => 'Mengukur lingkaran tabung kaleng bekas', 'artwork' => 'Tempat pensil', 'hour' => '5', 'created_at' => '2020-08-28 13:36:56', 'updated_at' => '2020-08-28 13:36:56'),
            array('id' => '10', 'school_profile_id' => '1', 'subject' => 'Fisika', 'teacher' => 'Friska', 'class' => '8', 'period' => '2', 'aspect_id' => '5', 'hook' => 'Mengukur suhu', 'artwork' => 'Kompos', 'hour' => '2', 'created_at' => '2020-08-28 13:38:07', 'updated_at' => '2020-08-28 13:38:07'),
            array('id' => '11', 'school_profile_id' => '1', 'subject' => 'Bhs Inggris', 'teacher' => 'Mustado', 'class' => '7', 'period' => '1', 'aspect_id' => '3', 'hook' => 'Mengenal istilah tanaman bahasa inggis', 'artwork' => 'Papan nama tanaman', 'hour' => '3', 'created_at' => '2020-08-28 13:40:50', 'updated_at' => '2020-08-28 13:40:50'),
            array('id' => '12', 'school_profile_id' => '1', 'subject' => 'Biologi', 'teacher' => 'Arman', 'class' => '8', 'period' => '1', 'aspect_id' => '3', 'hook' => 'Ragam tanaman', 'artwork' => 'KOlam ikan', 'hour' => '4', 'created_at' => '2020-08-28 13:53:04', 'updated_at' => '2020-08-28 13:53:04'),
            array('id' => '13', 'school_profile_id' => '1', 'subject' => 'Bahasa Perancis', 'teacher' => 'Widiastuti', 'class' => '8', 'period' => '1', 'aspect_id' => '4', 'hook' => 'Air untuk kehidupan', 'artwork' => 'Aqurium', 'hour' => '4', 'created_at' => '2020-08-28 13:54:39', 'updated_at' => '2020-08-28 13:54:39'),
            array('id' => '14', 'school_profile_id' => '1', 'subject' => 'Geografi', 'teacher' => 'Marjoko', 'class' => '8', 'period' => '2', 'aspect_id' => '4', 'hook' => 'Sungai dan endapan air tanah', 'artwork' => 'Membuat denah pembuangan air limbah', 'hour' => '4', 'created_at' => '2020-08-28 13:56:00', 'updated_at' => '2020-08-28 13:56:00'),
            array('id' => '15', 'school_profile_id' => '1', 'subject' => 'Matematika', 'teacher' => 'Wastarjo', 'class' => '8', 'period' => '2', 'aspect_id' => '4', 'hook' => 'Menghitung debit air', 'artwork' => 'Membuat rumus air', 'hour' => '4', 'created_at' => '2020-08-28 13:57:15', 'updated_at' => '2020-08-28 13:57:15'),
            array('id' => '16', 'school_profile_id' => '1', 'subject' => 'IPS', 'teacher' => 'Wagimin', 'class' => '8', 'period' => '1', 'aspect_id' => '3', 'hook' => 'Mengenal ekosistem', 'artwork' => 'Denah peta', 'hour' => '6', 'created_at' => '2020-08-28 13:58:46', 'updated_at' => '2020-08-28 13:58:46')
        );

        if (is_array($lesson_plans) && count($lesson_plans)) {
            LessonPlan::query()->insert($lesson_plans);
        }
    }
}
