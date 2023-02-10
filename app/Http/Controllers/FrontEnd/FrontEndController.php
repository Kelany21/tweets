<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Support\Str;

class FrontEndController extends Controller
{

    /**
     * @var null
     */
    protected $langObj = null;

    /**
     * @var null
     */
    protected $toolBar = ['createBtn' => false];

    public function __construct()
    {
        $currentLang = app()->getLocale();
        foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $key => $locale){
            if ($key != $currentLang){
                $this->langObj[] = [
                    'url' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedUrl($key),
                    'name' => $locale['native']
                ];
            }
        }
    }
}
