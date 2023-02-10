<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Groups::class);
        $this->call(Permissions::class);
        $this->call(Users::class);
    }
}
