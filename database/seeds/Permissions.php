<?php

use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        \App\Models\Permission::query()->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
        \Illuminate\Support\Facades\DB::table('group_permissions')->truncate();
        $modules = require path(base_path('routes/adminRouteMap')) . '.php';
        $defaultRoutes = require path(base_path('routes/defaultAdminRoute')) . '.php';
        /// loop on routes create permission for every route
        /// you can assign permissions for every route when you build
        /// route array check the route file
        foreach ($modules as $module) {
            if ($module['importDefaultRoute']) {
                foreach ($defaultRoutes as $defaultRoute) {
                    $defaultRoute['uri'] = $module['uri'] . $defaultRoute['uri'];
                    $defaultRoute['controller'] = $module['controller'] . $defaultRoute['controller'];
                    $module['routes'][] = $defaultRoute;
                }
            }
            $array = [];
            foreach ($module['routes'] as $route) {
                $key = $route['permission'] . '-' . $module['controller'];
                $array[$key]['controller'] = $module['controller'];
                $array[$key]['permission'] = $route['permission'];
                $array[$key]['slug'] = strtolower($key);
            }

            \App\Models\Permission::insert($array);
        }
        /// now link every permission with every group
        $groups = \App\Models\Group::get();
        $permissions = \App\Models\Permission::get();
        $permissions_ids = \Illuminate\Support\Arr::pluck($permissions, 'id');

        foreach ($groups as $group){
            $group->permissions()->attach($permissions_ids);
        }

    }
}
