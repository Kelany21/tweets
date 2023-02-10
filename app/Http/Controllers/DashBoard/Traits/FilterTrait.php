<?php
namespace App\Http\Controllers\DashBoard\Traits;

trait FilterTrait
{
    /** filter by any column index function
     * @param $rows
     * @return mixed
     */
    protected function filterIndex($rows)
    {
        return $rows;
    }

    /** build index filter ui
     * @return array
     */
    protected function filterIndexUi()
    {
        return [];
    }

    /** filter by any column show function
     * @param $row
     * @return mixed
     */
    protected function filterShow($row)
    {
        return $row;
    }

    /** filter by any delete function
     * @param $row
     * @return mixed
     */
    protected function filterEdit($row)
    {
        return $row;
    }

    /** filter by any delete function
     * @param $row
     * @return mixed
     */
    protected function filterDelete($row)
    {
        return $row;
    }
}
