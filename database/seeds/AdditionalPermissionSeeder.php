<?php

use Illuminate\Database\Seeder;
use App\Permission;

class AdditionalPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['title' => 'self_development_access'],

            ['title' => 'environmental_issue_access'],
            ['title' => 'environmental_issue_create'],
            ['title' => 'environmental_issue_edit'],
            ['title' => 'environmental_issue_show'],
            ['title' => 'environmental_issue_delete'],

            ['title' => 'extracurricular_access'],
            ['title' => 'extracurricular_create'],
            ['title' => 'extracurricular_edit'],
            ['title' => 'extracurricular_show'],
            ['title' => 'extracurricular_delete'],

            ['title' => 'habituation_access'],
            ['title' => 'habituation_create'],
            ['title' => 'habituation_edit'],
            ['title' => 'habituation_show'],
            ['title' => 'habituation_delete'],

        ];

        if (is_array($permissions) && count($permissions)) {
            Permission::query()->insert($permissions);
        }
    }
}
