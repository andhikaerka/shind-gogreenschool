<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'title' => 'Super Admin',
            ],
            [
                'id' => 2,
                'title' => 'Admin',
            ],
            [
                'id' => 3,
                'title' => 'Operator',
            ],
            [
                'id' => 4,
                'title' => 'School',
            ],
            [
                'id' => 5,
                'title' => 'Team',
            ],
            [
                'id' => 6,
                'title' => 'Cadre',
            ],
            [
                'id' => 7,
                'title' => 'Work Group',
            ],
        ];

        if (is_array($roles) && count($roles)) {
            Role::query()->insert($roles);
        }
    }
}
