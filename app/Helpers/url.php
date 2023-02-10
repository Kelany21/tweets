<?php

/***
 * @param $path
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
 */
function u($path)
{
    return url('/' . \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() . '/' . $path);
}

/**
 * @param $path
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
 */
function uA($path)
{
    return url(app()->getLocale().'/dashboard/' . $path);
}

/**
 * @return mixed
 */
function defaultImage()
{
    return env('DEFAULT_IMAGE', url('img/SD-default-image.png'));
}

/**
 * @param $row
 * @param string $column
 * @return mixed
 */
function image($row, $relation = 'images', $column = 'image', $default_image = '')
{
    if ($relation) {
        return isset($row->{$relation}[0]->{$column}) && $row->{$relation}[0]->{$column} != '' ? $row->{$relation}[0]->{$column} : ($default_image ? url($default_image) : defaultImage());
    }

    return isset($row->{$column}) && $row->{$column} != '' ? $row->{$column} : ($default_image ? url($default_image) : defaultImage());
}

/**
 * @param $string
 * @return string|string[]
 */
function slug($string)
{
    return str_replace([' ', '&', '|'], '', $string);
}

/**
 * get image from request
 * rename image
 * save image and return full url
 * @param $request
 * @param $key
 * @return mixed|string
 */
function upload($request, $key)
{
    $date = \Carbon\Carbon::now();
    $path = 'uploads' . DIRECTORY_SEPARATOR . $date->year . DIRECTORY_SEPARATOR . $date->month . DIRECTORY_SEPARATOR . $date->day;
    $full_path = base_path('public' . DIRECTORY_SEPARATOR . $path);
    if (!\Illuminate\Support\Facades\File::exists($full_path)) {
        \Illuminate\Support\Facades\File::makeDirectory($full_path, $mode = 0777, true, true);
    }
    $image = defaultImage();
    if ($request->hasFile($key)) {
        $image = $request->file($key);
        $name = time() . '.' . $image->getClientOriginalExtension();;
        $image->move($full_path, $name);
        $image = url($path . '/' . $name);
    }

    return $image;
}


/****
 * @param int $length
 * @param int $userId
 * @param int $jobId
 * @return string
 */
function generateCode(int $userId, int $productId, $length = 16)
{
    return $userId . '-' . $productId . '-' . code($length);
}

/***
 * @param $length
 * @return false|string
 */
function code($length)
{
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}
