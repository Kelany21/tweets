<?php

namespace App\Http\Controllers\DashBoard\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

trait StoreUpdateTrait
{
    /*     * **
     * @param $request
     * @param array $array
     */

    protected function removeEmpty(&$request, $array = [])
    {
        foreach ($request as $key => $input) {
            if (in_array($key, $array)) {
                if (is_array($input) && empty($input)) {
                    unset($request[$key]);
                } elseif ($input == '') {
                    unset($request[$key]);
                }
            }
        }
    }

    protected function repeatForm()
    {
        return [];
    }

    protected function repeateFormHandler($row, $request)
    {
        if (!empty($this->repeatForm())) {
            if ($this->action == 'store') {
                $this->storeRepaeter($row, $request);
            } else {
                $this->updateRepaeter($row, $request);
            }
        }
    }

    protected function buildLoopNumber($value, $request)
    {
        $largerCount = 0;
        foreach ($value['cols'] as $colkey) {
            if (isset($request[$colkey])) {
                $count = count($request[$colkey]);
                $largerCount = $count > $largerCount ? $count : $largerCount;
            }
        }
        return $largerCount;
    }

    protected function updateRepaeter($row, $request)
    {
        foreach ($this->repeatForm() as $key => $value) {
            $db = new $value['class']();
            $deleteQuery = $db->where($value['foreignKey'] , $row->id);
            if ($value['relation'] === 'morphRelation') {
                $deleteQuery = $deleteQuery->where($value['morphColumn'], $value['morphClass']);
            }
            if (isset($request[$value['idsColumn']])) {
                $deleteQuery = $deleteQuery->whereNotIn('id', $request[$value['idsColumn']]);
            }
            $deleteQuery->delete();
            for ($i = 0; $i < $this->buildLoopNumber($value, $request); $i++) {
                $data = [];
                foreach ($value['cols'] as $col) {
                    if (isset($request[$col][$i])) {
                        $data[$col] = $request[$col][$i];
                    } else {
                        $data[$col] = '';
                    }
                    $data[$value['foreignKey']] = $row->id;
                    if ($value['relation'] === 'morphRelation') {
                        $data[$value['morphColumn']] = $value['morphClass'];
                    }
                }
                if (isset($request[$value['idsColumn']]) && isset($request[$value['idsColumn']][$i])) {
                    $db->where('id', $request[$value['idsColumn']][$i])->update($data);
                } else {
                    $db->create($data);
                }
            }
        }
    }

    protected function storeRepaeter($row, $request)
    {
        foreach ($this->repeatForm() as $key => $value) {
            for ($i = 0; $i < $this->buildLoopNumber($value, $request); $i++) {
                $data = [];
                foreach ($value['cols'] as $col) {
                    if (isset($request[$col][$i])) {
                        $data[$col] = $request[$col][$i];
                    } else {
                        $data[$col] = '';
                    }
                    $data[$value['foreignKey']] = $row->id;
                    if ($value['relation'] === 'morphRelation') {
                        $data[$value['morphColumn']] = $value['morphClass'];
                    }
                }
                $create = new $value['class']();
                $create->create($data);
            }
        }
    }

    /**
     * @param array $ids
     */
    protected function hookBeforeUpdateColumnBulkAction($ids = [])
    {
        return;
    }

    /**
     * @param array $ids
     */
    protected function hookAfterUpdateColumnBulkAction($ids = [])
    {
        return;
    }

    /**
     * @param array $ids
     */
    protected function hookBeforeBulkDelete($ids = [])
    {
        return;
    }

    /**
     * @param array $ids
     */
    protected function hookBeforeBulkRestore($ids = [])
    {
        return;
    }

    /**
     * @param array $ids
     */
    protected function hookAfterBulkRestore($ids = [])
    {
        return;
    }

    /**
     * @param array $ids
     */
    protected function hookAfterBulkDelete($ids = [])
    {
        return;
    }

    /**
     * @param array $ids
     */
    protected function hookAfterDeleteSelectedPermanently($ids = [])
    {
        return;
    }

    /**
     * @param array $ids
     */
    protected function hookBeforeDeleteSelectedPermanently($ids = [])
    {
        return;
    }

    /**
     * @param $row
     */
    protected function hookBeforeDelete($row)
    {
        return;
    }

    /**
     * @param $row
     */
    protected function hookAfterDelete($row)
    {
        return;
    }

    /**
     * @param $row
     */
    protected function hookBeforeDeletePermanently($row)
    {
        return;
    }

    /**
     * @param $row
     */
    protected function hookAfterDeletePermanently($row)
    {
        return;
    }

    /**
     * @param $row
     */
    protected function hookBeforeRestore($row)
    {
        return;
    }

    /**
     * @param $row
     */
    protected function hookAfterRestore($row)
    {
        return;
    }

    /**
     * @param $row
     * @param $request
     */
    protected function hookBeforeUpdate($row, $request)
    {
        return;
    }

    /**
     * @param $row
     * @param $request
     */
    protected function hookAfterUpdate($row, $request)
    {
        return;
    }

    /**
     * @param $request
     */
    protected function hookBeforeStore($request)
    {
        return;
    }

    /**
     * @param $row
     * @param $request
     */
    protected function hookAfterStore($row, $request)
    {
        return;
    }

    /**
     * @return array
     */
    protected function appendStoreRequest()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function appendUpdateRequest()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function appendToCreateValidation()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function appendToUpdateValidation()
    {
        return [];
    }

    /**
     * @param $request
     * @param string $action
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    protected function validateRequest($request, $action = 'Create')
    {
        $nameSpace = $this->buildRequestNameSpace($action);
        $validation = new $nameSpace();
        $rules = $validation->rules();
        $rules = $this->appendTransCols($rules);
        if ($action == 'Create') {
            $rules = $rules + $this->appendToCreateValidation();
        } else {
            $rules = $rules + $this->appendToUpdateValidation();
        }
        $validator = Validator::make($request, $rules, $validation->messages(), $validation->attributes());
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        return true;
    }

    protected function appendTransCols($rules)
    {
        foreach ($this->model->translateable as $cols) {
            if (key_exists($cols, $rules)) {
                foreach (config('laravellocalization.supportedLocales') as $key => $lang) {
                    $rules[$cols . '_' . $key] = $rules[$cols];
                }
                unset($rules[$cols]);
            }
        }
        return $rules;
    }

    /**
     * @param string $action
     * @return string
     */
    protected function buildRequestNameSpace($action = 'Create')
    {
        $nameSpace = "\\App\\Http\\Requests\\DashBoard\\" . $this->module . "\\";
        if (class_exists($nameSpace . $action)) {
            return $nameSpace . $action;
        }

        return $nameSpace . 'Create';
    }

    /**
     * @return string
     */
    protected function redirectAfterStore()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function redirectAfterDelete($row)
    {
        return '';
    }

    /**
     * @return string
     */
    protected function redirectAfterToggle($row)
    {
        return '';
    }

    /**
     * @return string
     */
    protected function redirectAfterDeletePermanently()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function redirectAfterDeleteSelectedPermanently()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function redirectAfterBulkRestore()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function redirectAfterRestore()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function redirectAfterUpdate()
    {
        return '';
    }

    /**
     * @return array
     */
    protected function removeEmptyInputInUpdate()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function removeEmptyInputInStore()
    {
        return [];
    }

    /**
     * @param $request
     * @param array $array
     * @return array
     */
    public function removeFromRequest($request, $array = [])
    {
        $array = array_merge($array, $this->defaultExceptFromArray());
        return Arr::except($request, $array);
    }

    /**
     * @return array
     */
    protected function exceptUpdate()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function exceptStore()
    {
        return [];
    }

    /**
     * @return string[]
     */
    protected function defaultExceptFromArray()
    {
        return [
            '_token',
            '_method'
        ];
    }

    /**
     * before index call
     */
    protected function beforeIndexHook()
    {
        return;
    }

}
