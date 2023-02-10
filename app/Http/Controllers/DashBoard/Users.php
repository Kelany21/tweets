<?php

namespace App\Http\Controllers\DashBoard;

use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class Users
 * @package App\Http\Controllers\DashBoard
 */
class Users extends BackEnd
{

    /**
     * @var bool
     */
    protected $exportBtn = false;

    protected $allGroups = [];

    public function __construct(Model $model = null)
    {
        parent::__construct($model);
        $this->allGroups = groups();
    }

    protected function appendToSharedDataInViews()
    {
        return ['allGroups' => $this->allGroups];
    }

    /**
     * @var string
     */
    protected $moduleIcon = 'flaticon-users-1';

    /**
     * @var int[]
     */
    protected $notAllowToDelete = [1];

    /**
     * @var string
     */
    protected $editAbleColumnForLogs = 'name';

    /**
     * @param int $id
     */
    public function statusToggle(int $id)
    {
        $row = $this->model->where('id', $id)->first();
        $row->update(['status' => statusesToggle()[$row->status]]);
    }

    /**
     * @param array $array
     * @return array
     */
    protected function appendToIndex($array = [])
    {
        $all = $this->model->whereHas('group', function (Builder $query) {
            $query->where('can_access_admin', 'no');
        })->count();
        return [
            'usersCount' => $all,
        ];
    }

    protected function approximatelySearchColumns(): array
    {
        return ['name', 'email'];
    }

    protected function specialColumnsToAdd(): array
    {
        return [
            'tweets_count' => function($row) {
                return count($row->tweets);
            }
        ];
    }

    /**
     * @return array|array[]
     */
    protected function filterIndexUi()
    {
        $groups = $this->allGroups;
        $groups->prepend(['name' => trans('admin.select_groups'), 'id' => '', 'disabled' => true, 'selected' => true]);
        return [
            [
                'type' => 'text',
                'name' => 'name',
                'label' => trans('admin.username'),
                'icon' => 'flaticon2-search-1 text-muted',
                'class' => 'col-lg-2',
                'inputClass' => 'datatable-input',
                'value' => ROO('name'),
                'attr' => [
                    'data-col-index' => 1
                ]
            ],
            [
                'type' => 'text',
                'name' => 'email',
                'label' => trans('admin.email'),
                'icon' => 'flaticon-envelope text-muted',
                'class' => 'col-lg-2',
                'inputClass' => 'datatable-input',
                'value' => ROO('email'),
                'attr' => [
                    'data-col-index' => 2
                ]
            ],
            [
                'type' => 'select',
                'name' => 'group_id',
                'label' => trans('admin.group_id'),
                'icon' => 'flaticon-security text-muted',
                'class' => 'col-lg-2',
                'inputClass' => 'datatable-input',
                'options' => $groups,
                'value' => ROO('group_id'),
                'labelKey' => 'name',
                'valueKey' => 'id',
                'attr' => [
                    'data-col-index' => 3
                ]
            ],
            [
                'type' => 'select',
                'name' => 'status',
                'label' => trans('admin.status'),
                'icon' => 'flaticon-envelope text-muted',
                'class' => 'col-lg-2',
                'inputClass' => 'datatable-input',
                'options' => statuses()->prepend(['label' => trans('admin.select_statuses'), 'value' => '', 'disabled' => true, 'selected' => true]),
                'value' => ROO('status'),
                'attr' => [
                    'data-col-index' => 4
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
                'label' => trans('admin.username'),
                'data' => 'name',
                'name' => 'name',
                'render' => 'name',
            ],
            [
                'label' => trans('admin.email'),
                'data' => 'email',
                'name' => 'email',
            ],
            [
                'label' => trans('admin.group_id'),
                'data' => 'group_id',
                'name' => 'group_id',
                'render' => 'group_id',
                'orderable' => false,
            ],
            [
                'label' => trans('admin.tweets_count'),
                'data' => 'tweets_count',
                'name' => 'tweets_count',
            ],
            [
                'label' => trans('admin.status'),
                'data' => 'status',
                'name' => 'status',
                'render' => 'status',
                'orderable' => false,
            ],
        ];
    }

    /**
     * @param $row
     * @return array|\array[][]
     */
    protected function cards($row)
    {
        $groups = $this->allGroups;
        $groups->prepend(['name' => trans('admin.select_groups'), 'id' => '', 'disabled' => true, 'selected' => true]);
        return [
            'cards' => [
                [
                    'type' => 'normal',
                    'class' => 'col-lg-2',
                    'header' => [
                        'title' => trans('admin.avatar'),
                        'icon' => 'flaticon-avatar'
                    ],
                    'body' => [
                        'inputs' => [
                            [
                                'type' => 'image',
                                'name' => 'picture',
                                'label' => trans('admin.picture'),
                                'placeHolder' => trans('admin.picture'),
                                'icon' => 'flaticon-user-add text-muted',
                                'value' => RowOrOld($row, 'picture'),
                                'class' => 'col-lg-12',
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'tabs',
                    'class' => 'col-lg-10',
                    'body' => [
                        'tabs' => [
                            [
                                'label' => trans('admin.info'),
                                'id' => 'info',
                                'icon' => 'flaticon-information text-muted',
                                'content' => [
                                    'inputs' => [
                                        [
                                            'type' => 'text',
                                            'name' => 'name',
                                            'label' => trans('admin.username'),
                                            'placeHolder' => trans('admin.username'),
                                            'icon' => 'flaticon-user-add text-muted',
                                            'value' => RowOrOld($row, 'name'),
                                            'class' => 'col-lg-12',
                                        ],
                                        [
                                            'type' => 'email',
                                            'name' => 'email',
                                            'placeHolder' => trans('admin.email'),
                                            'label' => trans('admin.email'),
                                            'value' => RowOrOld($row, 'email'),
                                            'class' => 'col-lg-12',
                                        ],
                                        [
                                            'type' => 'password',
                                            'name' => 'password',
                                            'label' => trans('admin.password'),
                                            'placeHolder' => trans('admin.password'),
                                            'value' => '',
                                            'class' => 'col-lg-6',
                                        ],
                                    ]
                                ]
                            ],
                            [
                                'label' => trans('admin.access'),
                                'id' => 'access',
                                'icon' => 'flaticon-lock text-muted',
                                'content' => [
                                    'inputs' => [
                                        [
                                            'type' => 'select',
                                            'name' => 'group_id',
                                            'label' => trans('admin.group_id'),
                                            'placeHolder' => trans('admin.group_id'),
                                            'icon' => 'flaticon-security text-muted',
                                            'value' => RowOrOld($row, 'group_id'),
                                            'class' => 'col-lg-3',
                                            'options' => $groups,
                                            'labelKey' => 'name',
                                            'valueKey' => 'id',
                                        ],
                                        [
                                            'type' => 'radio',
                                            'name' => 'status',
                                            'label' => trans('admin.status'),
                                            'value' => RowOrOld($row, 'status'),
                                            'class' => 'col-lg-3',
                                            'options' => statuses()
                                        ]
                                    ]
                                ]
                            ],
                        ]
                    ]
                ],
            ]
        ];
    }

    /**
     * @return array|string[]
     */
    protected function removeEmptyInputInUpdate()
    {
        return [
            'password'
        ];
    }
}
