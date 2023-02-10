<?php




$routes = require_once 'adminRouteMap.php';
$defaultRoutes = require_once 'defaultAdminRoute.php';

//$urls = [];
foreach ($routes as $route) {
    if ($route['importDefaultRoute']) {
        foreach ($defaultRoutes as $defaultRoute) {
            $defaultRoute['uri'] = $route['uri'] . $defaultRoute['uri'];
            $defaultRoute['controller'] = $route['controller'] . $defaultRoute['controller'];
            $route['routes'][] = $defaultRoute;
        }
    }
    foreach ($route['routes'] as $route) {
//        dump($route['type']." => dashboard/".$route['uri']);
//        $urls[] = $route['type']." => dashboard/".$route['uri'];
        switch ($route['type']) {
            case $route['type'] == 'resource':
                Route::resource($route['uri'], $route['controller'])->except(['show', 'delete']);
                break;
            case  $route['type'] == 'get':
                Route::get($route['uri'], $route['controller']);
                break;
            case  $route['type'] == 'put':
                Route::put($route['uri'], $route['controller']);
                break;
            case $route['type'] == 'post':
                Route::post($route['uri'], $route['controller']);
                break;
        }
    }
}
//dd($urls);


// Quick search dummy route to display html elements in search dropdown (header search)
Route::get('/quick-search', 'PagesController@quickSearch')->name('quick-search');

