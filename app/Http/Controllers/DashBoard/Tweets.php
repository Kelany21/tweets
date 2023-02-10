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
class Tweets extends BackEnd
{

    /**
     * @var bool
     */
    protected $exportBtn = false;
    protected $createBtn = false;
    protected $allowDeleteBulkAction = false;
    protected $allowDelete = false;
    protected $allowEdit = false;

    /**
     * @var string
     */
    protected $moduleIcon = 'flaticon-twitter-logo';

    /**
     * @var int[]
     */
    protected $notAllowToDelete = [1];

    /**
     * @var string
     */
    protected $editAbleColumnForLogs = 'text';

    /**
     * @param int $id
     */
    public function statusToggle(int $id)
    {
        $row = $this->model->where('id', $id)->first();
        $row->update(['status' => statusesToggle()[$row->status]]);
    }

    protected function appendToIndex($array = [])
    {
        $array['allowAction'] = false;
        return $array;
    }

    protected function approximatelySearchColumns(): array
    {
        return ['text'];
    }

    protected function columnsToAdd(): array
    {
        return ['author', 'seenUsers'];
    }

    protected function specialColumnsToAdd(): array
    {
        return [
            'sees_count' => function($row) {
                return count($row->seenUsers);
            }
        ];
    }

    /**
     * @return array|array[]
     */
    protected function filterIndexUi()
    {
        $users = users()->prepend(['name' => trans('admin.select_user'), 'id' => '', 'disabled' => true, 'selected' => true]);
        $statuses = statuses()->prepend(['label' => trans('admin.select_statuses'), 'value' => '', 'disabled' => true, 'selected' => true]);
        return [
            [
                'type' => 'select',
                'name' => 'user_id',
                'label' => trans('admin.author'),
                'icon' => 'flaticon-envelope text-muted',
                'class' => 'col-lg-4',
                'inputClass' => 'datatable-input',
                'options' => $users,
                'value' => ROO('user_id'),
                'labelKey' => 'name',
                'valueKey' => 'id',
                'attr' => [
                    'data-col-index' => 1
                ]
            ],
            [
                'type' => 'text',
                'name' => 'text',
                'label' => trans('admin.text'),
                'icon' => 'flaticon2-search-1 text-muted',
                'class' => 'col-lg-3',
                'inputClass' => 'datatable-input',
                'value' => ROO('text'),
                'attr' => [
                    'data-col-index' => 2
                ]
            ],
            [
                'type' => 'select',
                'name' => 'status',
                'label' => trans('admin.status'),
                'icon' => 'flaticon-envelope text-muted',
                'class' => 'col-lg-4',
                'inputClass' => 'datatable-input',
                'options' => $statuses,
                'value' => ROO('status'),
                'attr' => [
                    'data-col-index' => 3
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
                'label' => trans('admin.author'),
                'data' => 'author',
                'name' => 'user_id',
                'render' => 'author',
            ],
            [
                'label' => trans('admin.text'),
                'data' => 'text',
                'name' => 'text',
                'render' => 'text',
            ],
            [
                'label' => trans('admin.update_count'),
                'data' => 'update_count',
                'name' => 'update_count',
            ],
            [
                'label' => trans('admin.sees_count'),
                'data' => 'sees_count',
                'name' => 'sees_count',
            ],
            [
                'label' => trans('admin.status'),
                'data' => 'status',
                'name' => 'status',
                'render' => 'status',
                'orderable' => false,
            ],
            [
                'label' => trans('admin.seenUsers'),
                'data' => 'seenUsers',
                'name' => 'seenUsers',
                'render' => 'seenUsers',
                'orderable' => false,
            ],
        ];
    }
}
