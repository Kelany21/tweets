<?php

/**
 * @param string $message
 * @param string $title
 * @param string $type
 * @return string
 */
function alert(string $message = "", string $title = "", string $type = "success")
{
    session()->flash('alert', ['title' => $title, 'message' => $message, 'type' => $type]);
}

/***
 * @param string $message
 * @param string $title
 * @return string
 */
function success(string $message = "", string $title = "")
{
    return alert($message, $title);
}

/**
 * @param string $message
 * @param string $title
 * @return string
 */
function danger(string $message = "", string $title = "")
{
    return alert($message, $title, "error");
}

/**
 * @param string $message
 * @param string $title
 * @param string $type
 */
function wAlert($message = "", $title = "", $type = "success")
{
    session()->flash('website-alert', ['title' => $title, 'type' => $type, 'message' => $message]);
}

/***
 * @param $array
 */
function wConfirm($array)
{
    session()->flash('website-alert', $array + ['type' => 'confirm']);
}

/**
 * @param string $message
 * @param string $title
 */
function wSuccess($message = "", $title = "")
{
    wAlert($message, $title, 'success');
}


/**
 * @param string $message
 * @param string $title
 */
function wDanger($message = "", $title = "")
{
    wAlert($message, $title, 'error');
}
