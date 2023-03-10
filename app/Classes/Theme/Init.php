<?php

namespace App\Classes\Theme;

use App\Classes\Theme\Metronic;

class Init
{
    /**
     * @return string
     */
    protected static function getConfigFile(): string
    {
        if (str_contains(request()->path(), 'dashboard')) {
            return 'layout';
        } else {
            return 'website-layout';
        }
    }

    public static function run()
    {
        self::initPageLoader();
        self::initLayout();
        self::initHeader();
        self::initSubheader();
        self::initContent();
        self::initAside();
        self::initFooter();
    }

    private static function initLayout()
    {
        Metronic::addAttr('body', 'id', 'kt_body');

        // Offcanvas directions
        Metronic::addClass('body', 'quick-panel-right');
        Metronic::addClass('body', 'demo-panel-right');
        Metronic::addClass('body', 'offcanvas-right');
    }

    private static function initPageLoader()
    {
        if (!empty(config(self::getConfigFile() . '.page-loader.type'))) {
            Metronic::addClass('body', 'page-loading-enabled');
            Metronic::addClass('body', 'page-loading');
        }
    }

    private static function initHeader()
    {
        if (config(self::getConfigFile() . '.header.self.fixed.desktop')) {
            Metronic::addClass('body', 'header-fixed');
            Metronic::addClass('header', 'header-fixed');
        } else {
            Metronic::addClass('body', 'header-static');
        }

        if (config(self::getConfigFile() . '.header.self.fixed.mobile')) {
            Metronic::addClass('body', 'header-mobile-fixed');
            Metronic::addClass('header-mobile', 'header-mobile-fixed');
        }

        // Menu
        if (config(self::getConfigFile() . '.header.menu.self.display')) {
            Metronic::addClass('header_menu', 'header-menu-layout-' . config(self::getConfigFile() . '.header.menu.self.layout'));

            if (config(self::getConfigFile() . '.header.menu.self.root-arrow')) {
                Metronic::addClass('header_menu', 'header-menu-root-arrow');
            }
        }

        if (config(self::getConfigFile() . '.header.self.width') === 'fluid') {
            Metronic::addClass('header-container', 'container-fluid');
        } else {
            Metronic::addClass('header-container', 'container');
        }
    }

    private static function initSubheader()
    {
        if (config(self::getConfigFile() . '.subheader.display')) {
            Metronic::addClass('body', 'subheader-enabled');
        } else {
            return;
        }

        $subheader_style = config(self::getConfigFile() . '.subheader.style');
        $subheader_fixed = config(self::getConfigFile() . '.subheader.fixed');

        // Fixed content head
        if (config(self::getConfigFile() . '.subheader.fixed') && config(self::getConfigFile() . '.header.self.fixed.desktop')) {
            Metronic::addClass('body', 'subheader-fixed');
            $subheader_style = 'solid';
        } else {
            $subheader_fixed = false;
        }

        if ($subheader_style) {
            Metronic::addClass('subheader', 'subheader-' . $subheader_style);
        }
        if (config(self::getConfigFile() . '.subheader.width') == 'fluid') {
            Metronic::addClass('subheader-container', 'container-fluid');
        } else {
            Metronic::addClass('subheader-container', 'container');
        }

        if (config(self::getConfigFile() . '.subheader.clear')) {
            Metronic::addClass('subheader', 'subheader-clear');
        }
    }

    private static function initContent()
    {
        if (config(self::getConfigFile() . '.content.fit-top')) {
            Metronic::addClass('content', 'pt-0');
        }

        if (config(self::getConfigFile() . '.content.fit-bottom')) {
            Metronic::addClass('content', 'pt-0');
        }
        if (config(self::getConfigFile() . '.content.width') == 'fluid') {
            Metronic::addClass('content-container', 'container-fluid');
        } else {
            Metronic::addClass('content-container', 'container');
        }
    }

    private static function initAside()
    {
        if (config(self::getConfigFile() . '.aside.self.display') != true) {
            return;
        }

        // Enable Aside
        Metronic::addClass('body', 'aside-enabled');

        // Fixed Aside
        if (config(self::getConfigFile() . '.aside.self.fixed')) {
            Metronic::addClass('body', 'aside-fixed');
            Metronic::addClass('aside', 'aside-fixed');
        } else {
            Metronic::addClass('body', 'aside-static');
        }

        // Check Aside
        if (config(self::getConfigFile() . '.aside.self.display') != true) {
            return;
        }

        // Default fixed
        if (config(self::getConfigFile() . '.aside.self.minimize.default')) {
            Metronic::addClass('body', 'aside-minimize');
        }

        // Menu
        // Dropdown Submenu
        if (config(self::getConfigFile() . '.aside.menu.dropdown') == true) {
            Metronic::addClass('aside_menu', 'aside-menu-dropdown');
            Metronic::addAttr('aside_menu', 'data-menu-dropdown', '1');
        }

        // Scrollable Menu
        if (config(self::getConfigFile() . '.aside.menu.dropdown') != true) {
            Metronic::addAttr('aside_menu', 'data-menu-scroll', "1");
        } else {
            Metronic::addAttr('aside_menu', 'data-menu-scroll', "0");
        }

        if (config(self::getConfigFile() . '.aside.menu.submenu.dropdown.hover-timeout')) {
            Metronic::addAttr('aside_menu', 'data-menu-dropdown-timeout', config(self::getConfigFile() . '.aside.menu.submenu.dropdown.hover-timeout'));
        }
    }

    private static function initFooter()
    {
        // Fixed header
        if (config(self::getConfigFile() . '.footer.fixed') == true) {
            Metronic::addClass('body', 'footer-fixed');
        }

        if (config(self::getConfigFile() . '.footer.width') == 'fluid') {
            Metronic::addClass('footer-container', 'container-fluid');
        } else {
            Metronic::addClass('footer-container', 'container');
        }
    }

}
