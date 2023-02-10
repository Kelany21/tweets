<?php

namespace App\Http\Controllers\DashBoard\Traits;

trait WithTrait
{
    /**
     * @return array
     */
    protected function withIndex()
    {
        return [];
    }

    /**  append relation with show function
     * @param $row
     * @return mixed
     */
    protected function withShow($row)
    {
        return $row;
    }

    /**  append relation with delete function
     * @param $row
     * @return mixed
     */
    protected function withEdit($row)
    {
        return $row;
    }

}
