<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Groups extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        \App\Models\Group::query()->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
        $groups = [
            [
                'name' => 'admin',
                'description' => 'admin group',
                'can_access_admin' => 'yes'
            ],
            [
                'name' => 'user',
                'description' => 'users group',
                'can_access_admin' => 'no'
            ],
        ];

        foreach ($groups as $group) {
            \App\Models\Group::create($group);
        }
    }
}
