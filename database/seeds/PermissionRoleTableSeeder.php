<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        //super admin
        $permissions = Permission::all();
        Role::query()->findOrFail(1)->permissions()->sync($permissions->pluck('id'));

        //admin
        $admin_permissions_1 = Permission::query()
        ->where('title', 'not like', '%_edit%')
        ->where('title', 'not like', '%_delete%')
        ->where('title', 'not like', '%_create%')
        ->pluck('id')->toArray();

        $admin_permissions_2 = Permission::where('title', 'like', '%assessment_%')
            ->orWhere('title', 'like', '%password%')
            ->pluck('id')->toArray();

        $admin_permissions = array_merge($admin_permissions_1, $admin_permissions_2);
        Role::query()->findOrFail(2)->permissions()->sync($admin_permissions);

        //operator
        $operator_permissions_1 = Permission::query()
        ->where('title', 'not like', '%_edit%')
        ->where('title', 'not like', '%_delete%')
        ->where('title', 'not like', '%_create%')
        ->pluck('id')->toArray();

        $operator_permissions_2 = Permission::where('title', 'like', '%assessment_%')
            ->orWhere('title', 'like', '%password%')
            ->pluck('id')->toArray();

            $operator_permissions = array_merge($operator_permissions_1, $operator_permissions_2);
        Role::query()->findOrFail(3)->permissions()->sync($operator_permissions);

        //school
        $school_permissions = Permission::where('title', 'not like', '%content_%')
            ->where('title', 'not like', '%city_%')
            ->where('title', 'not like', '%province_%')
            ->where('title', 'not like', '%curriculum_calendar_%')
            ->where('title', 'not like', '%disaster_threat_%')
            ->where('title', 'not like', '%user_%')
            ->where('title', 'not like', '%role_%')
            ->where('title', 'not like', '%permission_%')
            ->where('title', 'not like', '%permission_%')
            ->where('title', 'not like', '%account_%')
            ->pluck('id')->toArray();
        Role::query()->findOrFail(4)->permissions()->sync($school_permissions);
        //team
        Role::query()->findOrFail(5)->permissions()->sync($school_permissions);

        //kader siswa
        $cadre_permissions_1 = Permission::where('title', 'not like', '%content_%')
            ->where('title', 'not like', '%city_%')
            ->where('title', 'not like', '%province_%')
            ->where('title', 'not like', '%curriculum_calendar_%')
            ->where('title', 'not like', '%disaster_threat_%')
            ->where('title', 'not like', '%user_%')
            ->where('title', 'not like', '%role_%')
            ->where('title', 'not like', '%permission_%')
            ->where('title', 'not like', '%_edit%')
            ->where('title', 'not like', '%_delete%')
            ->where('title', 'not like', '%_create%')
            ->pluck('id')->toArray();

        $cadre_permissions_2 = Permission::where('title', 'like', '%cadre_%')
            ->orwhere('title', 'like', '%work_program_%')
            ->orwhere('title', 'like', '%implementation_activity_access%')
            ->orwhere('title', 'like', '%activity_%')
            ->pluck('id')->toArray();

        $cadrePermissions = array_merge($cadre_permissions_1, $cadre_permissions_2);
        Role::query()->findOrFail(6)->permissions()->sync($cadrePermissions);

    }
}
