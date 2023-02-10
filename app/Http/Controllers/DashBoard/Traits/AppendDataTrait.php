<?php

namespace App\Http\Controllers\DashBoard\Traits;


trait AppendDataTrait
{
    /*** append array of data passed to view
     * @param array $array
     * @return array
     */
    protected function appendToIndex($array = [])
    {
        return $array;
    }

    /*** append array of data passed to view
     * @param array $array
     * @return array
     */
    protected function appendToShow($array = [])
    {
        return $array;
    }

    /** filter by any delete function
     * @param $array
     * @return mixed
     */
    protected function appendToEdit($array = [])
    {
        return $array;
    }

    /**
     * @param array $array
     * @return array
     */
    protected function appendToCreate($array = [])
    {
        return $array;
    }

    /**
     * @return array
     */
    protected function appendIndexBreadCrumbs()
    {
        return [];
    }

    /***
     * @return array
     */
    protected function appendCreateBreadCrumbs()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function appendEditBreadCrumbs()
    {
        return [];
    }
}
