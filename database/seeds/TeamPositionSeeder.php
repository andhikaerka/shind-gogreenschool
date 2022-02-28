<?php

use App\TeamPosition;
use Illuminate\Database\Seeder;

class TeamPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team_positions = array(
            array('id' => '1', 'slug' => 'penasehat', 'name' => 'Penasehat', 'created_at' => '2020-04-11 20:23:54', 'updated_at' => '2020-04-11 20:23:54'),
            array('id' => '2', 'slug' => 'penjab', 'name' => 'Penjab', 'created_at' => '2020-04-11 20:24:10', 'updated_at' => '2020-04-11 20:24:10'),
            array('id' => '3', 'slug' => 'ketua', 'name' => 'Ketua', 'created_at' => '2020-04-11 20:24:19', 'updated_at' => '2020-04-11 20:24:19'),
            array('id' => '4', 'slug' => 'wakil-ketua', 'name' => 'Wakil Ketua', 'created_at' => '2020-04-11 20:24:31', 'updated_at' => '2020-04-11 20:24:31'),
            array('id' => '5', 'slug' => 'sekretaris', 'name' => 'Sekretaris', 'created_at' => '2020-04-11 20:24:39', 'updated_at' => '2020-04-11 20:24:39'),
            array('id' => '6', 'slug' => 'bendahara', 'name' => 'Bendahara', 'created_at' => '2020-04-11 20:24:46', 'updated_at' => '2020-04-11 20:24:46'),
            array('id' => '7', 'slug' => 'lainnya-isi-manual', 'name' => 'Lainnya ... isi manual', 'created_at' => '2020-04-11 20:24:46', 'updated_at' => '2020-04-11 20:24:46')
        );

        if (is_array($team_positions) && count($team_positions)) {
            TeamPosition::query()->insert($team_positions);
        }
    }
}
