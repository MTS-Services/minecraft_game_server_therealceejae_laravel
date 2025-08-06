<?php

namespace Database\Seeders;

use Azuriom\Models\Role;
use Azuriom\Models\Setting;
use Azuriom\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Role::exists()) {
            return;
        }

        $defaultRole = Role::create([
            'name' => trans('seed.roles.member'),
            'color' => 'a5a5a5',
        ]);

        if ($defaultRole->id !== 1) {
            Setting::updateSettings('roles.default', $defaultRole->id);
        }

        Role::create([
            'name' => trans('seed.roles.admin'),
            'color' => 'e10d11',
            'is_admin' => true,
            'power' => 10,
        ]);

        User::where('id', 1)->update([
            'role_id' => 2,
        ]);
        User::where('id', 2)->update([
            'role_id' => 1,
        ]);
    }
}
