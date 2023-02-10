<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        \App\Models\User::query()->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
        $users = [
            [
                'name' => 'Omar Kelany',
                'password' => '123456',
                'email' => 'admin@admin.com',
                'picture' => 'http://jssors8.azureedge.net/demos/image-slider/img/px-action-athlete-athletes-848618-image.jpg',
                'status' => 'active',
                'group_id' => 1,
            ]
        ];
        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
