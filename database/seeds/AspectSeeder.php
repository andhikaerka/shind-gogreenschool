<?php

use App\Aspect;
use Illuminate\Database\Seeder;

class AspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aspects = array(
            array('id' => '1', 'slug' => 'sampah', 'name' => 'Sampah', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '2', 'slug' => 'energi', 'name' => 'Energi', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '3', 'slug' => 'kehati', 'name' => 'Kehati', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '4', 'slug' => 'air', 'name' => 'Air', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '5', 'slug' => 'kantin', 'name' => 'Kantin', 'created_at' => NULL, 'updated_at' => NULL)
        );

        if (is_array($aspects) && count($aspects)) {
            Aspect::query()->insert($aspects);
        }
    }
}
