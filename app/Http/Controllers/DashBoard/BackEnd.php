<?php

namespace App\Http\Controllers\DashBoard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashBoard\Traits\AppendDataTrait;
use App\Http\Controllers\DashBoard\Traits\CrudTrait;
use App\Http\Controllers\DashBoard\Traits\ExportTrait;
use App\Http\Controllers\DashBoard\Traits\FilterTrait;
use App\Http\Controllers\DashBoard\Traits\IndexTrait;
use App\Http\Controllers\DashBoard\Traits\ModelTrait;
use App\Http\Controllers\DashBoard\Traits\StoreUpdateTrait;
use App\Http\Controllers\DashBoard\Traits\WithTrait;
use App\Http\Controllers\DashBoard\Traits\TranslationTrait;
use App\Http\Middleware\Admin;
use App\Models\Group;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BackEnd
 * @package App\Http\Controllers\DashBoard
 */
class BackEnd extends Controller
{
    use  ModelTrait, CrudTrait, FilterTrait, WithTrait, AppendDataTrait, TranslationTrait, IndexTrait, StoreUpdateTrait, ExportTrait;

    /**
     * @var null
     */
    protected $model = null;

    /***
     * @var bool
     */
    protected $allowDeleteBulkAction = true;

    /**
     * @var null
     */
    protected $module = null;

    /**
     * @var null
     */
    protected $moduleName = null;

    /**
     * @var null
     */
    protected $moduleTitle = null;

    /**
     * @var null
     */
    protected $indexView = null;

    /**
     * @var null
     */
    protected $editView = null;

    /**
     * @var null
     */
    protected $createView = null;

    /**
     * @var string
     */
    protected $moduleIcon = 'fas fa-align-justify';

    /**
     * @var string
     */
    protected $createBtnIcon = 'la la-plus';

    /**
     * @var string
     */
    protected $updateBtnIcon = 'la la-check';

    /**
     * @var string
     */
    protected $deleteBtnIcon = 'la la-trash';

    /**
     * @var bool
     */
    protected $createBtn = true;


    /**
     * @var bool
     */
    protected $updateBtn = true;

    /**
     * @var bool
     */
    protected $exportBtn = true;

    /**
     * @var bool
     */
    protected $search = true;

    /**
     * @var null
     */
    protected $moduleRoute = null;

    /**
     * @var null
     */
    protected $action = null;

    /**
     * @var bool
     */
    protected $allowDelete = true;

    /**
     * @var bool
     */
    protected $allowDeletePermanently = true;

    /**
     * @var bool
     */
    protected $allowEdit = true;

    /**
     * @var array
     */
    protected $notAllowToDelete = [];

    /**
     * @var array
     */
    protected $manyToManyRelation = [];

    /**
     * @var array
     */
    protected $modulePermissions = [];

    /**
     * @var string
     */
    protected $editAbleColumnForLogs = '';

    /**
     * @var array
     */
    protected $repeatForm = [];

    /**
     * BackEnd constructor.
     * @param Model|null $model
     */
    public function __construct(Model $model = null)
    {
        $this->setModel($model);
        $this->middleware(Admin::class);
        $this->middleware(function ($request, $next) {
            $this->permissions($this->getModulePermissions());
            return $next($request);
        });
    }


    protected function permissions($options)
    {
        // get routes first
        $controllerName = class_basename(get_class($this));
        // get all routes
        $routes = require base_path('routes/adminRouteMap.php');
        // get default routes
        $defaultRoutes = require base_path('routes/defaultAdminRoute.php');
        // append default routes if allow
        $allRoutes = !$routes[$controllerName]['importDefaultRoute'] ? $routes[$controllerName]['routes'] : array_merge($routes[$controllerName]['routes'], $defaultRoutes);
        // fetch function name
        $functionName = '@' . request()->route()->getActionMethod();
        $permissionOfFunction = null;
        // get permission of current action
        foreach ($allRoutes as $route) {
            if (str_replace($controllerName, '', $route['controller']) === $functionName) {
                $permissionOfFunction = $route['permission'];
                break;
            }
        }
        // check if permission has current permission
        if (!in_array($permissionOfFunction, $options)) {
            danger(trans('admin.error'), trans('admin.you_are_not_authorized'));
            if ($permissionOfFunction != 'all') {
                return redirect()->back();
            } else {
                abort(401);
            }
        }
    }

    /***
     * @return array
     */
    protected function getModulePermissions()
    {
        // get controller
        $routeController = class_basename(get_class($this));
        // get permissions from database
        $groupPermissions = Group::with(['permissions' => function ($query) use ($routeController) {
            $query->where('controller', $routeController);
        }])->find(auth()->user()->group_id);
        // get group allow permissions in array
        $allPermissions = [];
        foreach ($groupPermissions->permissions as $permission) {
            $allPermissions[$permission->permission] = $permission->permission;
        }
        // set permission
        $this->modulePermissions = $allPermissions;
        // disable delete
        if (!in_array('delete', $allPermissions)) {
            $this->allowDelete = false;
        }
        // disable edit
        if (!in_array('edit', $allPermissions)) {
            $this->allowEdit = false;
        }
        // disable create
        if (!in_array('create', $allPermissions)) {
            $this->createBtn = false;
        }

        return $allPermissions;
    }
}
