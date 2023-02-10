<?php

namespace App\Http\Controllers\DashBoard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

/**
 * Class Groups
 * @package App\Http\Controllers\Dashboard
 */
class Groups extends BackEnd
{

    /**
     * @var bool
     */
    protected $exportBtn = false;

    /**
     * @var string[]
     */
    protected $manyToManyRelation = [
        [
            'relationName' => 'permissions',
            'columnName' => 'permission'
        ]
    ];

    /**
     * @var string
     */
    protected $editAbleColumnForLogs = 'name';

    /**
     * @var string
     */
    protected $moduleIcon = 'flaticon2-group';

    /**
     * @var int[]
     */
    protected $notAllowToDelete = [1];

    protected function approximatelySearchColumns(): array
    {
        return ['name'];
    }

    /**
     * @return array|array[]
     */
    protected function filterIndexUi()
    {
        return [
            [
                'type' => 'text',
                'name' => 'name',
                'label' => trans('admin.name'),
                'icon' => 'flaticon2-search-1 text-muted',
                'class' => 'col-lg-2',
                'inputClass' => 'datatable-input',
                'value' => ROO('name'),
                'attr' => [
                    'data-col-index' => 1
                ]
            ],
        ];
    }

    /**
     * @return array|array[]
     */
    protected function normalColumns(): array
    {
        return [
            [
                'label' => trans('admin.name'),
                'data' => 'name',
                'name' => 'name',
                'render' => 'name',
            ],
        ];
    }

    /**
     * @param $row
     * @return array|\array[][]
     */
    protected function cards($row)
    {
        return [
            'cards' => [
                [
                    'type' => 'normal',
                    'class' => 'col-lg-5',
                    'header' => [
                        'title' => trans('admin.info'),
                        'icon' => 'flaticon-plus'
                    ],
                    'body' => [
                        'inputs' => [
                            [
                                'type' => 'text',
                                'name' => 'name',
                                'label' => trans('admin.name'),
                                'placeHolder' => trans('admin.name'),
                                'icon' => 'flaticon-user-add text-muted',
                                'value' => RowOrOld($row, 'name'),
                                'class' => 'col-lg-6',
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'can_access_admin',
                                'label' => trans('admin.can_access_admin'),
                                'value' => RowOrOld($row, 'can_access_admin'),
                                'class' => 'col-lg-6',
                                'options' => yesNoOptions()
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'description',
                                'placeHolder' => trans('admin.description'),
                                'label' => trans('admin.description'),
                                'value' => RowOrOld($row, 'description'),
                                'class' => 'col-lg-12',
                                'attr' => [
                                    'rows' => 8
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'normal',
                    'class' => 'col-lg-7',
                    'showOnCreate' => false,
                    'header' => [
                        'title' => trans('admin.permissions'),
                        'icon' => 'flaticon2-shield text-muted',
                    ],
                    'body' => [
                        'inputs' => [
                            [
                                'type' => 'checkboxs',
                                'name' => 'permission[]',
                                'label' => trans('admin.permission'),
                                'placeHolder' => trans('admin.permission'),
                                'class' => 'col-lg-12',
                                'options' => Permission::orderBy('controller', 'asc')->get(),
                                'value' => OOD('permission', $row->permissions()->pluck('permission_id')->toArray()),
                                'groupBy' => ['controller'],
                                'labelKey' => 'permission',
                                'valueKey' => 'id',
                            ],
                        ]
                    ]
                ]
            ]
        ];
    }

}
