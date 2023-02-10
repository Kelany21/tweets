<?php

/**
 * @return mixed
 */
function pageTemplate(){
    $route = request()->route();
    $uri = explode("/" , $route->uri())[1];
    return \App\Models\PageTemplate::where('route', $uri)->first();
}

/**
 * @return string
 */
function getThemeBasedOnRoute()
{
    $pageThemeInfo = pageTemplate();
    return getPageLayout($pageThemeInfo->page_theme , $pageThemeInfo->app_theme);
}

/**
 * @param $pages
 * @param $theme
 * @return string
 */
function getPageLayout($pages, $theme)
{
    return getPagesPath($pages, $theme) . 'layout';
}

/***
 * @param $sectionName
 * @param null $page
 * @param null $theme
 * @return string
 */
function getSectionFolder($sectionName, $page = null, $theme = null)
{
    return getPagesPath($page, $theme) . 'sections.' . $sectionName;
}

/***
 * @param $theme
 * @return string
 */
function getThemePath($theme)
{
    return 'frontend.themes.' . ($theme ?? getDefaultTheme()) . '.';
}

/***
 * @param $pages
 * @param $theme
 * @return string
 */
function getPagesPath($pages, $theme)
{
    return getThemePath($theme) . 'pages.' . ($pages ?? getDefaultPage()) . '.';
}

/***
 * @return mixed
 */
function getDefaultTheme()
{
    return env('DEFAULT_THEME');
}

/***
 * @return mixed
 */
function getDefaultPage()
{
    return env('DEFAULT_PAGE');
}
