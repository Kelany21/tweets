<?php

/**
 * @return string
 */
function DS()
{
    return DIRECTORY_SEPARATOR;
}

/***
 * @param $path
 * @return string|string[]
 */
function path($path)
{
    return str_replace('.', DS(), $path);
}

/**
 * @param $path
 * @return string|string[]
 */
function dots($path){
    return str_replace(DS(), '.', $path);
}
