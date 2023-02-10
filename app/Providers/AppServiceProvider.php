<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $direction = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection();
        if ($direction === 'rtl') {
            config(['layout.self.rtl' => true]);
        }

//        $settings = collect([]);

        try {
            $settings = Setting::get();
        }catch (\Exception $exception){
            $settings = collect([]);
        }

        View::share('settings', $settings);
    }
}
