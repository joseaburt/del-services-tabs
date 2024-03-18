<?php

namespace Delinternet\Plugins\Widgets;

use Elementor\Widget_Base;

/**
 * Have the widget code for the Custom Elementor Nav Menu.
 */

class Nav_Menu extends Widget_Base
{

    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts() {
        wp_enqueue_script('delinternet-menu-js', plugin_dir_url(__FILE__) . '../assets/js/menu.js');
        wp_enqueue_style('delinternet-menu-css', plugin_dir_url(__FILE__) . '../assets/css/menu.css');
    }

    public function get_name()
    {
        return 'delinternet-menu';
    }


    public function get_title()
    {
        return __('Delinternet Menu', 'delinternet-elementor-widgets');
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    public function get_categories()
    {
        return ['delinternet'];
    }

    public function _register_control()
    {
    }

    public function get_style_depends()
    {
        return ['delinternet-menu-css'];
    }

    public function get_script_depends()
    {
        return ['delinternet-menu-js'];
    }


    // Frontend
    protected function render()
    {
        echo wp_nav_menu(
            array(
                'container' => 'div',
                'container_class' => 'delinternet_menu_container',
                'menu_class' => 'delinternet_menu',
            )
        );
    }

    protected function _content_template()
    {

        echo wp_nav_menu(
            array(
                'container' => 'div',
                'container_class' => 'delinternet_menu_container',
                'menu_class' => 'delinternet_menu',
            )
        );
    }
}
