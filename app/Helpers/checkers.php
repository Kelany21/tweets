<?php

/** check if exists in request only
 * @param string $key
 * @return mixed|null
 */
function RO(string $key = '')
{
    return request()->has($key) ? request()->get($key) : null;
}

/** check if exists in request and old
 * @param string $key
 * @return mixed|null
 */
function ROO(string $key = '', $default = null)
{
    $r = RO($key);
    $o = old($key, $default);
//    return $r ? $r : ($o ? $o : null);
    return $r ?? $o ?? $default;
}

/***
 * check if exists in row and on old
 * @param $row
 * @param $key
 * @return mixed|null
 */
function RowOrOld($row, $key, $indexOfValue = null)
{
    if ($row->{$key}) {
        return $row->{$key};
    }

    if (is_array(old($key))) {
        // dd($row, $key, $indexOfValue);

        if (isset(old($key)[$indexOfValue])) {
            return old($key)[$indexOfValue];
        }
        return null;
    }

    return old($key);
}

/***
 * @param $name
 * @param $data
 * @param string $type
 * @return array|mixed|null
 */
function OOD($name, $data, $type = 'array')
{
    // dd(old('is_default'));
    return old($name) ?? ($data ?? ($type == 'array' ? [] : null));
}

/** check if exists in old or in request
 * @param string $key
 * @return mixed|null
 */
function OOR(string $key = '')
{
    $r = RO($key);
    $o = old($key);
    return $o ? $o : ($r ? $r : null);
}

/*** clear text from tags trim text if need
 * @param string $text
 * @return string
 */
function clearText($text = null, $limit = '')
{
    if ($limit != '') {
        $text = str_limit($text, $limit, '..');
    }
    $text = strip_tags(stripslashes($text));
    return preg_replace("/&nbsp;/", '', $text);
}

/***
 * @param $index
 * @param $value
 * @return bool
 */
function checkSegment($index, $value)
{
    return request()->segment($index) && request()->segment($index) === $value;
}
