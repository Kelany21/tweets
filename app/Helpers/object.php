<?php

/**
 * @param $arr
 * @param $key
 * @return mixed
 */
function deleteIndex(&$arr, $key)
{
    if (isset($arr[$key])) {
        unset($arr[$key]);
    }
    return $arr;
}

/**
 * @param $key
 * @param $settings
 * @return mixed
 */
function getSingleSetting($key, $settings)
{
    return $settings->where('slug', $key)->first()->value;
}

/**
 * @param $key
 * @return mixed
 */
function getSettingValue($key)
{
    return \App\Models\Setting::where('slug', $key)->first()->value;
}
