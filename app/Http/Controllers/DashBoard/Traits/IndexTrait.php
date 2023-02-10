<?php

namespace App\Http\Controllers\DashBoard\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

trait IndexTrait
{

    /**
     * @param $request
     * @param $columnName
     * @param $value
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function updateColumnsOnBulkAction($request, $columnName, $value)
    {
        try {
            if ($request->get('ids') && !empty($request->get('ids'))) {
                /// add any logic before update
                $this->hookBeforeUpdateColumnBulkAction($request->get('ids'));
                /// save database
                $delete = $this->model->whereIn('id', $request->get('ids'))->update([$columnName => $value]);
                /// add any logic after update
                $this->hookAfterUpdateColumnBulkAction($request->get('ids'));
                if ($delete) {
                    success(trans('admin.done'), trans('admin.row_has_been_updated'));
                    return redirect(uA($this->moduleName));
                }
            }
            danger(trans('admin.error'), trans('admin.please_select_some_rows'));
            return redirect()->back();
        } catch (\Exception $e) {
            danger(trans('admin.error'), trans('admin.exception_happen'));
            return redirect()->back();
        }
    }

    /***
     * @return array
     */
    protected function bulkAction()
    {
        $array = [
            'title' => trans('admin.actions'),
            'delete_menu' => [],
            'menu' => []
        ];
        if ($this->allowDeleteBulkAction || $this->allowDelete) {
            $array['delete_menu'] = [
                [
                    'label' => trans('admin.restoreSelected'),
                    'action' => uA($this->moduleName . '/restore-selected'),
                    'id' => 'restoreSelected',
                    'permission' => 'restore',
                    'hasConfirm' => [
                        'title' => trans('admin.are_you_sure_restore_rows'),
                        'text' => trans('admin.You_wont_be_able_to_revert_this!'),
                        'confirmButtonText' => trans('admin.Yes,_restore_it!')
                    ]
                ],
                [
                    'label' => trans('admin.deleteSelectedPermanently'),
                    'action' => uA($this->moduleName . '/delete-permanently-selected'),
                    'id' => 'deleteSelectedPermanently',
                    'permission' => 'delete',
                    'hasConfirm' => [
                        'title' => trans('admin.are_you_sure_delete_rows'),
                        'text' => trans('admin.You_wont_be_able_to_revert_this!'),
                        'confirmButtonText' => trans('admin.Yes,_delete_it!')
                    ]
                ],
            ];
        }
        if ($this->allowDeleteBulkAction) {
            $array['menu'] = [
                [
                    'label' => trans('admin.deleteSelected'),
                    'action' => uA($this->moduleName . '/delete-selected'),
                    'id' => 'deleteSelected',
                    'permission' => 'delete',
                    'hasConfirm' => [
                        'title' => trans('admin.are_you_sure_delete_rows'),
                        'text' => trans('admin.You_wont_be_able_to_revert_this!'),
                        'confirmButtonText' => trans('admin.Yes,_delete_it!')
                    ]
                ]
            ];
        }
        $array['menu'] = array_merge($array['menu'], $this->appendToBulkActions());
        $array['delete_menu'] = array_merge($array['delete_menu'], $this->appendToDeletedBulkActions());

        return $array;
    }

    /***
     * @return array
     */
    protected function appendToBulkActions()
    {
        return [];
    }

    /***
     * @return array
     */
    protected function appendToDeletedBulkActions()
    {
        return [];
    }

    /** api to get table data
     * @return mixed
     * @throws \Exception
     */
    public function getRows()
    {
        if (request()->has('delete') && request()->get('delete') == 'true') {
            $query = $this->model->query()->onlyTrashed();
        } else {
            $query = $this->model->query();
        }

        $with = $this->withIndex();

        if ($with) {
            $query = $query->with($with);
        }
        $datatable = DataTables::eloquent($query)
            ->order(function ($query) {
                $this->order($query);
            })
            ->filter(function ($query) {
                $this->filterDataTable($query);
            })
            ->addIndexColumn()
            ->addColumns($this->additionalColumns())
            ->rawColumns(['Actions'])
            ->smart(false);
        foreach ($this->specialColumnsToAdd() as $columnName => $columnFunction) {
            $datatable->addColumn($columnName, $columnFunction);
        }
        return $datatable->toJson();
    }

    /** handel order of
     * @param $query
     * @return mixed
     */
    protected function order($query)
    {
        if ($order = ROO('order')) {
            $order = $order[0];
            if ($order['column'] == 0) {
                $query->orderBy('id', 'desc');
            } else {
                $columns = $this->model->getFillable();
                $query->orderBy($columns[intval($order['column']) - 1], $order['dir']);
            }
        }
    }

    /***
     * @param $query
     */
    protected function filterDataTable($query)
    {
        if (isset(request()->all()['columns'])) {
            foreach (request()->all()['columns'] as $column) {
                if ($column['search']['value']) {
                    if (key_exists($column['name'], $this->rangeColumns())) {
                        $col = $this->rangeColumns()[$column['name']];
                        $array = explode($col['separator'], $column['search']['value']);
                        $query->whereBetween(DB::Raw($col['rawFunction']), $array);
                    } else if (in_array($column['name'], $this->approximatelySearchColumns())) {
                        $query->where($column['name'], 'like', '%' . $column['search']['value'] . '%');
                    } else if (key_exists($column['name'], $this->searchWithOperatorColumns())) {
                        $query->where(
                            $column['name'],
                            $this->searchWithOperatorColumns()[$column['name']],
                            $column['search']['value']
                        );
                    } else if (key_exists($column['name'], $this->searchWithFunctionColumns())) {
                        $col = $this->searchWithFunctionColumns()[$column['name']];
                        $query->where(
                            DB::Raw($col['function'] . '(`' . $column['name'] . '`)'),
                            $col['operator'],
                            $column['search']['value']
                        );
                    } else if (key_exists($column['name'], $this->searchWithRelationsColumns())) {
                        $col = $this->searchWithRelationsColumns()[$column['name']];
                        $whereHasFunction = null;
                        $lastRelation = null;
                        $relations = explode('.', $col['relations']);
                        for ($i = count($relations) - 1; $i >= 0; $i--) {
                            if ($whereHasFunction) {
                                $whereHasFunction = function (Builder $query) use ($lastRelation, $whereHasFunction) {
                                    return $query->whereHas($lastRelation, $whereHasFunction);
                                };
                            } else {
                                $whereHasFunction = function (Builder $query) use ($col, $column) {
                                    return $query->where(
                                        $col['columnName'],
                                        $col['operator'],
                                        $col['appendBeforeValue'] . $column['search']['value'] . $col['appendAfterValue']
                                    );
                                };
                            }
                            $lastRelation = $relations[$i];
                        }
                        $query->whereHas($lastRelation, $whereHasFunction);
                    } else {
                        $query->where($column['name'], $column['search']['value']);
                    }
                }
            }
            foreach ($this->hasRelations() as $column) {
                $query->has($column['relations'], $column['operator'], $column['count']);
            }
            foreach ($this->columnsToSearch() as $column) {
                if ($column['value']) {
                    $query->where($column['columnName'], $column['operator'], $column['value']);
                }
            }
            foreach ($this->whereHasColumns() as $column) {
                if ($column['value']) {
                    $whereHasFunction = null;
                    $lastRelation = null;
                    $relations = explode('.', $column['relations']);
                    for ($i = count($relations) - 1; $i >= 0; $i--) {
                        if ($whereHasFunction) {
                            $whereHasFunction = function (Builder $query) use ($lastRelation, $whereHasFunction) {
                                return $query->whereHas($lastRelation, $whereHasFunction);
                            };
                        } else {
                            $whereHasFunction = function (Builder $query) use ($column) {
                                return $query->where($column['columnName'], $column['operator'], $column['value']);
                            };
                        }
                        $lastRelation = $relations[$i];
                    }
                    $query->whereHas($lastRelation, $whereHasFunction);
                }
            }
        }
    }

    protected function additionalColumns(): array
    {
        return ['Actions' => 'id'] + $this->columnsToAdd();
    }

    protected function columnsToAdd(): array
    {
        return [];
    }

    protected function specialColumnsToAdd(): array
    {
        return [];
    }

    protected function appendToIndexQuery(): array
    {
        return [];
    }

    /**
     * @return array|string[][]
     */
    protected function rangeColumns(): array
    {
        return $this->appendToRangColumn() + [
                "created_at" => [
                    'rawFunction' => 'DATE(created_at)',
                    'separator' => '|'
                ],
                "updated_at" => [
                    'rawFunction' => 'DATE(updated_at)',
                    'separator' => '|'
                ]
            ];
    }

    /**
     * @return array
     */
    protected function approximatelySearchColumns(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    protected function searchWithOperatorColumns(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    protected function searchWithFunctionColumns(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    protected function searchWithRelationsColumns(): array
    {
        return [];
    }

    protected function hasRelations(): array
    {
//        array example
//        return [
//            [
//                'relations' => 'relation1.relation2.relation3',
//                'operator' => 'operator',
//                'count' => 'count of related relation',
//            ]
//        ];
        return [];
    }

    protected function whereHasColumns(): array
    {
//        array example
//        return [
//            [
//                'relations' => 'relation1.relation2.relation3',
//                'columnName' => 'column_name',
//                'operator' => 'operator',
//                'value' => ROO('input_name'),
//            ]
//        ];
        return [];
    }

    protected function columnsToSearch(): array
    {
//        array example
//        return [
//            [
//                'columnName' => 'column_name',
//                'operator' => 'operator',
//                'value' => ROO('input_name'),
//            ],
//        ];
        return [];
    }

    /**
     * @return array
     */
    protected function appendToRangColumn(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function normalColumns(): array
    {
        return [];
    }
}
