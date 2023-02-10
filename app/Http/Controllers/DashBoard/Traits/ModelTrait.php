<?php

namespace App\Http\Controllers\DashBoard\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait ModelTrait
{

    /**
     * @var null
     */
    protected $haveModel = true;
    /** if you want to change the controller model just pass
     * Eloquent model object else will init model based on Controller name
     * @param Model $model
     */
    protected function setModel(Model $model = null)
    {
        $controllerPass = explode('\\', get_class($this));
        $exController = end($controllerPass);
        if (!$model) {
            if ($this->haveModel){
                $modelPath = 'App\\Models\\' . Str::singular($exController);
                $this->model = new  $modelPath();
            }
        } else {
            $this->model = $model;
        }
        $this->moduleName = Str::kebab($exController);
        $this->moduleRoute =  strtolower($exController);
        $this->module = $exController;
//        $this->moduleTitle = implode(' ',preg_split('/(?=[A-Z])/', $exController));
        $this->moduleTitle = __('admin.' . $this->moduleName);
//        $this->getModulePermissions();
    }
}
