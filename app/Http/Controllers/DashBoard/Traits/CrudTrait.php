<?php

namespace App\Http\Controllers\DashBoard\Traits;

use App\Models\Status;
use Illuminate\Http\Request;

trait CrudTrait
{

    /**
     * @return string
     */
    protected function getIndexView()
    {
        return $this->indexView ?? 'dashboard.' . $this->moduleName . '.index';
    }

    /**
     * @return string
     */
    protected function getEditView()
    {
        return $this->editView ?? 'dashboard.' . $this->moduleName . '.edit';
    }

    /**
     * @return string
     */
    protected function getCreateView()
    {
        return $this->createView ?? 'dashboard.' . $this->moduleName . '.create';
    }

    protected function view($view, $action, $cards = [], $bulkAction = [], $appendIndexBreadCrumbs = [], $sharedDataInViews = [])
    {
        $this->action = $action;
        $data = [
                'table' => $this->normalColumns(),
                'moduleLabel' => $this->transModuleName($action),
                'moduleDes' => $this->transModuleDes('-des-' . $action),
                'toolBar' => $this->getToolBarInfo(),
                'search' => [],
                'actionLabel' => title(trans('admin.' . $action)),
                'action' => $this->action,
                'cards' => $cards,
                'bulkAction' => $bulkAction,
                'page_breadcrumbs' => $this->defaultBreadCrumbs($this->action) + $appendIndexBreadCrumbs,
            ] + $sharedDataInViews + $this->sharedDataInViews();
        return view($view)->with($data);
    }

    /**
     * @return array
     */
    protected function sharedDataInViews()
    {
        return [
            'page_title' => $this->moduleTitle,
            'notAllowToDelete' => $this->notAllowToDelete,
            'allowEdit' => $this->allowEdit,
            'allowDelete' => $this->allowDelete,
            'allowDeletePermanently' => $this->allowDeletePermanently,
            'createBtnIcon' => $this->createBtnIcon,
            'updateBtnIcon' => $this->updateBtnIcon,
            'deleteBtnIcon' => $this->deleteBtnIcon,
            'moduleIcon' => $this->moduleIcon,
            'module' => $this->module,
            'moduleName' => $this->moduleName,
            'moduleRoute' => $this->moduleRoute,
            'modulePermissions' => $this->modulePermissions,
            'translateCols' => $this->model ? $this->model->getTranslateInputsOnly() : [],
            'cols' => $this->model ? $this->model->getFillable() : [],
            'repeteCols' => $this->repeatForm(),
        ] + $this->appendToSharedDataInViews();
    }

    /**
     * @return array
     */
    protected function appendToSharedDataInViews()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function additionalActions(): array
    {
        return [];
    }

    /*** load index page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->action = 'list';
        $this->beforeIndexHook();
        $data = [
                'table' => $this->normalColumns(),
                'moduleLabel' => $this->transModuleName('list'),
                'moduleDes' => $this->transModuleDes(),
                'toolBar' => $this->getToolBarInfo(),
                'search' => $this->getSearchArray(),
                'actionLabel' => title(trans('admin.list')),
                'action' => $this->action,
                'cards' => $this->indexCards(),
                'bulkAction' => $this->bulkAction(),
                'additionalActions' =>  $this->additionalActions(),
                'page_breadcrumbs' => $this->defaultBreadCrumbs($this->action) + $this->appendIndexBreadCrumbs(),
            ] + $this->sharedDataInViews() + $this->appendToIndex();
        return view($this->getIndexView())->with($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $row = $this->model;
        $row = $this->filterEdit($row);
        $row = $this->withEdit($row);
        $row = $row->findOrFail($id);
        $this->action = 'edit';


        $data = [
                'row' => $row,
                'moduleLabel' => $this->transModuleName('edit'),
                'moduleDes' => $this->transEditModuleDes(),
                'toolBar' => $this->getToolBarInfo(),
                'cards' => $this->cards($row),
                'actionLabel' => title(trans('admin.edit')),
                'action' => $this->action,
                'page_breadcrumbs' => $this->defaultBreadCrumbs($this->action) + $this->appendEditBreadCrumbs(),
            ] + $this->appendToEdit() + $this->sharedDataInViews();


        return view($this->getEditView())->with($data);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $row = $this->model;
        $this->action = 'create';

        $data = [
                'row' => $row,
                'moduleLabel' => $this->transModuleName('create'),
                'moduleDes' => $this->transCreateModuleDes(),
                'toolBar' => array_merge($this->getToolBarInfo(), ['createBtn' => false]),
                'cards' => $this->cards($row),
                'actionLabel' => title(trans('admin.create')),
                'action' => $this->action,
                'page_breadcrumbs' => $this->defaultBreadCrumbs($this->action) + $this->appendCreateBreadCrumbs(),
            ] + $this->appendToCreate() + $this->sharedDataInViews();
        return view($this->getCreateView())->with($data);
    }

    /***
     * @param $id
     * @param $column
     * @param $value
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function toggle($id, $column, $value)
    {
        $row = $this->model->findOrFail($id);
        $old = [$column => $row->{$column}];
        $new = [$column => $value];;
        $row->update([$column => $value]);
        success(trans('admin.done'), trans('admin.row_has_been_updated'));
        if ($this->redirectAfterToggle($row) !== '') {
            return redirect($this->redirectAfterToggle($row));
        }
        return redirect(uA($this->moduleName));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        try {
            $this->action = 'update';
            $row = $this->model->findOrFail($id);
            $old = $row->getOriginal();
            /// remove what user need + default
            $request = $this->removeFromRequest($request->all(), $this->exceptUpdate());
            /// remove empty value what user assign
            $this->removeEmpty($request, $this->removeEmptyInputInUpdate());
            /// append to request
            $request = $request + $this->appendUpdateRequest();
            /// validate
            $validate = $this->validateRequest($request, 'Update');
            if (!is_bool($validate)) {
                return $validate;
            }
            /// add any logic before update
            $this->hookBeforeUpdate($row, $request);
            /// save database
            $update = $row->update($request);
            /// update relation many to many
            $this->relations($row, $request);
            /// update repeated form if exits
            $this->repeateFormHandler($row, $request);
            /// add any logic after update
            $this->hookAfterUpdate($row, $request);
            if ($update) {
                $new = $row->getOriginal();
                success(trans('admin.done'), trans('admin.row_has_been_updated'));
                if ($request['action'] == 'saveBack') {
                    return redirect()->back();
                }
                if ($this->redirectAfterUpdate() !== '') {
                    return redirect($this->redirectAfterUpdate());
                }
                return redirect(uA($this->moduleRoute));
            }
            danger(trans('admin.error'), trans('admin.some_thing_wrong'));
            return redirect()->back();
        } catch (\Exception $e) {
            if (env('APP_DEBUG') == true) {
                dd($e);
            }
            danger(trans('admin.error'), trans('admin.exception_happen'));
            return redirect(uA($this->moduleRoute));
        }
    }

    /***
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $this->action = 'store';
            /// remove what user need + default
            $request = $this->removeFromRequest($request->all(), $this->exceptStore());
            /// remove empty value what user assign
            $this->removeEmpty($request, $this->removeEmptyInputInStore());
            /// append to request
            $request = $request + $this->appendStoreRequest();
            /// validate
            $validate = $this->validateRequest($request);
            if (!is_bool($validate)) {
                return $validate;
            }
            /// do some logic before store
            $this->hookBeforeStore($request);
            /// save database
            $store = $this->model->create($request);
            /// update relation many to many
            $this->relations($store, $request);
            /// update repeated form if exits
            $this->repeateFormHandler($store, $request);
            /// do some logic after store
            $this->hookAfterStore($store, $request);
            if ($store) {
                $new = $store->getOriginal();
                success(trans('admin.done'), trans('admin.row_has_been_created'));
                if ($request['action'] == 'saveBack') {
                    return redirect(uA($this->moduleRoute . '/' . $store->id . '/edit'));
                }
                if ($this->redirectAfterStore() !== '') {
                    return redirect($this->redirectAfterStore());
                }
                return redirect(uA($this->moduleRoute));
            }
            danger(trans('admin.error'), trans('admin.some_thing_wrong'));
            return redirect()->back();
        } catch (\Exception $e) {
            if (env('APP_DEBUG') == true) {
                dd($e);
            }
            danger(trans('admin.error'), trans('admin.exception_happen'));
            return redirect(uA($this->moduleRoute));
        }
    }

    /***
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        try {
            if (in_array($id, $this->notAllowToDelete)) {
                danger(trans('admin.error'), trans('admin.you_can_not_delete_id_one'));
                return redirect()->back();
            }
            $row = $this->model->findOrFail($id);
            /// add any logic before update
            $this->hookBeforeDelete($row);
            /// save database
            $delete = $this->model->find($id)->delete();
            /// add any logic after update
            $this->hookAfterDelete($row);
            if ($delete) {
                success(trans('admin.done'), trans('admin.row_has_been_deleted'));
                if ($this->redirectAfterDelete($row) !== '') {
                    return redirect($this->redirectAfterDelete($row));
                }
                return redirect(uA($this->moduleRoute));
            }
            danger(trans('admin.error'), trans('admin.some_thing_wrong'));
            return redirect()->back();
        } catch (\Exception $e) {
            danger(trans('admin.error'), trans('admin.exception_happen'));
            return redirect()->back();
        }
    }


    /***
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deletePermanently($id)
    {
        try {
            if (in_array($id, $this->notAllowToDelete)) {
                danger(trans('admin.error'), trans('admin.you_can_not_delete_id_one'));
                return redirect()->back();
            }
            $row = $this->model->withTrashed()->findOrFail($id);
            /// add any logic before update
            $this->hookBeforeDeletePermanently($row);
            /// save database
            $delete = $this->model->withTrashed()->find($id)->forceDelete();
            /// add any logic after update
            $this->hookAfterDeletePermanently($row);
            if ($delete) {
                success(trans('admin.done'), trans('admin.row_has_been_deleted'));
                if ($this->redirectAfterDeletePermanently() !== '') {
                    return redirect($this->redirectAfterDeletePermanently() . '?delete=true');
                }
                return redirect(uA($this->moduleRoute) . '?delete=true');
            }
            danger(trans('admin.error'), trans('admin.some_thing_wrong'));
            return redirect()->back();
        } catch (\Exception $e) {
            danger(trans('admin.error'), trans('admin.exception_happen'));
            return redirect()->back();
        }
    }

    /***
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore($id)
    {
        try {
            $row = $this->model->withTrashed()->findOrFail($id);
            /// add any logic before restore
            $this->hookBeforeRestore($row);
            /// save database
            $delete = $this->model->withTrashed()->find($id)->restore();
            /// add any logic after restore
            $this->hookAfterRestore($row);
            if ($delete) {
                success(trans('admin.done'), trans('admin.row_has_been_restore'));
                if ($this->redirectAfterRestore() !== '') {
                    return redirect($this->redirectAfterRestore() . '?delete=true');
                }
                return redirect(uA($this->moduleRoute) . '?delete=true');
            }
            danger(trans('admin.error'), trans('admin.some_thing_wrong'));
            return redirect()->back();
        } catch (\Exception $e) {
            danger(trans('admin.error'), trans('admin.exception_happen'));
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restoreSelected(Request $request)
    {
        try {
            if ($request->get('ids') && !empty($request->get('ids'))) {
                /// add any logic before update
                $this->hookBeforeBulkRestore($request->get('ids'));
                /// save database
                $delete = $this->model->withTrashed()->whereIn('id', $request->get('ids'))->restore();
                /// add any logic after update
                $this->hookAfterBulkRestore($request->get('ids'));
                if ($delete) {
                    success(trans('admin.done'), trans('admin.row_has_been_restored'));
                    if ($this->redirectAfterBulkRestore() !== '') {
                        return redirect($this->redirectAfterBulkRestore() . '?delete=true');
                    }
                    return redirect(uA($this->moduleRoute . '?delete=true'));
                }
            }
            danger(trans('admin.error'), trans('admin.please_select_some_rows'));
            return redirect()->back();
        } catch (\Exception $e) {
            danger(trans('admin.error'), trans('admin.exception_happen'));
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteSelected(Request $request)
    {
        try {
            if ($request->get('ids') && !empty($request->get('ids'))) {
                /// add any logic before update
                $this->hookBeforeBulkDelete($request->get('ids'));
                $ids = array_diff($request->get('ids'), $this->notAllowToDelete);
                /// save database
                $delete = $this->model->whereIn('id', $ids);
                $delete->delete();
                /// add any logic after update
                $this->hookAfterBulkDelete($request->get('ids'));
                if ($delete) {
                    success(trans('admin.done'), trans('admin.row_has_been_deleted'));
                    if ($this->redirectAfterDelete(null) !== '') {
                        return redirect($this->redirectAfterDelete(null));
                    }
                    return redirect(uA($this->moduleRoute));
                }
            }
            danger(trans('admin.error'), trans('admin.please_select_some_rows'));
            return redirect()->back();
        } catch (\Exception $e) {
            danger(trans('admin.error'), trans('admin.exception_happen'));
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteSelectedPermanently(Request $request)
    {
        try {
            if ($request->get('ids') && !empty($request->get('ids'))) {
                /// add any logic before update
                $this->hookBeforeDeleteSelectedPermanently($request->get('ids'));
                $ids = array_diff($request->get('ids'), $this->notAllowToDelete);
                /// save database
                $delete = $this->model->withTrashed()->whereIn('id', $ids)->forceDelete();
                /// add any logic after update
                $this->hookAfterDeleteSelectedPermanently($request->get('ids'));
                if ($delete) {
                    success(trans('admin.done'), trans('admin.row_has_been_deleted'));
                    if ($this->redirectAfterDeleteSelectedPermanently() !== '') {
                        return redirect($this->redirectAfterDeleteSelectedPermanently() . '?delete=true');
                    }
                    return redirect(uA($this->moduleRoute . '?delete=true'));
                }
            }
            danger(trans('admin.error'), trans('admin.please_select_some_rows'));
            return redirect()->back();
        } catch (\Exception $e) {
            danger(trans('admin.error'), trans('admin.exception_happen'));
            return redirect()->back();
        }
    }

    /**
     * @param string $action
     * @return mixed
     */
    protected function defaultBreadCrumbs($action = 'list')
    {
        $array[] = [
            'title' => trans('admin.home'),
            'page' => uA('home'),
            'icon' => 'fa fa-home'
        ];
        $array[] = [
            'title' => trans('admin.' . $this->moduleName),
            'page' => uA($this->moduleRoute),
            'icon' => $this->moduleIcon
        ];
        if ($action == 'create') {
            $array[] = [
                'title' => trans('admin.create'),
                'page' => uA($this->moduleRoute . '/create'),
                'icon' => $this->createBtnIcon
            ];
        } elseif ($action == 'edit') {
            $array[] = [
                'title' => trans('admin.edit'),
                'page' => request()->fullUrl(),
                'icon' => $this->updateBtnIcon
            ];
        }
        return $array;
    }

    /**
     * @return array
     */
    protected function getToolBarInfo()
    {
        return [
            'createBtn' => $this->createBtn,
            'exportBtn' => $this->exportBtn
        ];
    }

    /**
     * @return array
     */
    protected function getSearchArray()
    {
        return [
                'search' => $this->search,
            ] + ['inputs' => $this->filterIndexUi()];
    }

    /**
     * @param $row
     * @param $request
     */
    protected function relations($row, $request)
    {
        if (!empty($this->manyToManyRelation)) {
            foreach ($this->manyToManyRelation as $relation) {
                if (isset($request[$relation['columnName']])) {
                    $row->{$relation['relationName']}()->sync($request[$relation['columnName']]);
                } else {
                    $row->{$relation['relationName']}()->sync([]);
                }
            }
        }
    }

    /**
     * @return array
     */
    protected function indexCards()
    {
        return [];
    }

    /***
     * @param $row
     * @return array
     */
    protected function cards($row)
    {
        return [];
    }

    protected function inputForMultiLang($row, $cols = [], $type = 'text')
    {
        $array = [];
        foreach ($this->model->getTransFromarray($cols) as $col) {
            $array[] = [
                'type' => $type,
                'name' => $col,
                'label' => trans('admin.' . $col),
                'placeHolder' => trans('admin.' . $col),
                'icon' => 'flaticon-user-add text-muted',
                'value' => RowOrOld($row, $col),
                'class' => 'col-lg-6',
            ];
        }
        return $array;
    }
}
