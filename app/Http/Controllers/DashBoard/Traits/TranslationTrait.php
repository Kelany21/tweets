<?php

namespace App\Http\Controllers\DashBoard\Traits;

trait TranslationTrait
{

    /**
     * @param string $action
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    protected function transModuleName($action = 'list')
    {
        return $this->tansWithFile($this->moduleName.'_'.$action);
    }

    /***
     * @param string $des
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    protected function transModuleDes($des = '-index-des')
    {
        return $this->tansWithFile($this->moduleName.$des);
    }

    /**
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    protected function transCreateModuleDes()
    {
        return $this->tansWithFile($this->moduleName.'-create-des');
    }

    /**
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    protected function transEditModuleDes()
    {
        return $this->tansWithFile($this->moduleName.'-edit-des');
    }

    /**
     * @param $key
     * @param string $file
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    protected function tansWithFile($key, $file = 'admin.')
    {
        return trans($file . $key);
    }

}
