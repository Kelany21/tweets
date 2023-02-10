<?php

namespace App\Http\Middleware;

use App\Models\Group;
use Closure;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next  , ...$options)
    {
        // get routes first
        $controllerName = end($options);
        // get all routes
        $routes = require base_path('routes/adminRouteMap.php');
        // get default routes
        $defaultRoutes = require base_path('routes/defaultAdminRoute.php');
        // append default routes if allow
        $allRoutes = !$routes[$controllerName]['importDefaultRoute'] ? $routes[$controllerName]['routes']  : array_merge($routes[$controllerName]['routes'] , $defaultRoutes);
        // fetch function name
        $functionName= '@'.$request->route()->getActionMethod();
        $permissionOfFunction = null;
        // get permission of current action
        foreach ($allRoutes as $route){
            if(str_replace($controllerName , '' , $route['controller']) === $functionName){
                $permissionOfFunction = $route['permission'];
                break;
            }
        }

        // check if permission has current permission
        if(!in_array($permissionOfFunction , $options)){
            danger(trans('admin.error') , trans('admin.you_are_not_authorized'));
            if($permissionOfFunction != 'all'){
                return redirect()->back();
            }else{
                abort(401);
            }
        }

        return $next($request);
    }
}
