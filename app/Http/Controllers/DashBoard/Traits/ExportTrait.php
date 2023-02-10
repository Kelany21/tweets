<?php

namespace App\Http\Controllers\DashBoard\Traits;

use Carbon\Carbon;
use Faker\Factory;
use Yajra\DataTables\Facades\DataTables;

trait ExportTrait
{
    protected function dataToExport($request)
    {
        return $this->model->orderBy('id', 'desc')->get();
    }

    /**
     * @param $data
     * @return array
     */
    private function exportCollection($data)
    {
        $collection = [];
        foreach ($data as $item) {
            $collection[] = $this->exportedData($item);
        }
        return $collection;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function exportedData($data)
    {
        return $data;
    }

    /**
     * @return mixed
     */
    public function export()
    {
        ini_set('memory_limit','2500M');
        return collect($this->exportCollection($this->dataToExport(request())))->downloadExcel(
            Carbon::now()->timestamp . Factory::create()->numberBetween(0, 9) . ".xlsx",
            $writerType = null,
            $headings = true
        );
    }
}
