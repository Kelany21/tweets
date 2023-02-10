<?php

/***
 * @param $title
 * @return mixed
 */
function title($title)
{
    return \Illuminate\Support\Str::title($title);
}

/***
 * @param $title
 * @return mixed
 */
function langColumn($col)
{
    return $col.'_'.config('app.locale');
}
