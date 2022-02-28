<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        $role_user = array(
            array('user_id' => '1', 'role_id' => '1'),
            array('user_id' => '2', 'role_id' => '2'),
            array('user_id' => '3', 'role_id' => '3'),
            array('user_id' => '4', 'role_id' => '4'),
            array('user_id' => '6', 'role_id' => '5'),
            array('user_id' => '7', 'role_id' => '6'),
            array('user_id' => '17', 'role_id' => '6'),
            array('user_id' => '18', 'role_id' => '5'),
            array('user_id' => '19', 'role_id' => '4'),
            array('user_id' => '25', 'role_id' => '4'),
            array('user_id' => '26', 'role_id' => '4'),
            array('user_id' => '27', 'role_id' => '4'),
            array('user_id' => '28', 'role_id' => '4'),
            array('user_id' => '29', 'role_id' => '4'),
            array('user_id' => '30', 'role_id' => '4'),
            array('user_id' => '31', 'role_id' => '4'),
            array('user_id' => '32', 'role_id' => '4'),
            array('user_id' => '33', 'role_id' => '4'),
            array('user_id' => '34', 'role_id' => '4'),
            array('user_id' => '35', 'role_id' => '4'),
            array('user_id' => '36', 'role_id' => '4'),
            array('user_id' => '37', 'role_id' => '4'),
            array('user_id' => '38', 'role_id' => '4'),
            array('user_id' => '39', 'role_id' => '4'),
            array('user_id' => '40', 'role_id' => '4'),
            array('user_id' => '41', 'role_id' => '4'),
            array('user_id' => '42', 'role_id' => '4'),
            array('user_id' => '43', 'role_id' => '4'),
            array('user_id' => '44', 'role_id' => '6'),
            array('user_id' => '45', 'role_id' => '4'),
            array('user_id' => '51', 'role_id' => '4'),
            array('user_id' => '52', 'role_id' => '4'),
            array('user_id' => '53', 'role_id' => '4'),
            array('user_id' => '54', 'role_id' => '4'),
            array('user_id' => '55', 'role_id' => '4')
        );

        if (is_array($role_user) && count($role_user)) {
            DB::table('role_user')->insert($role_user);
        }
    }
}
