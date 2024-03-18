<?php 

namespace Delinternet\Plugins\Widgets;

use Elementor\Widget_Base;


class DelinternetServiceTabWidget extends Widget_Base {
    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts() {
        wp_enqueue_script('delinternet-services-tabs-js', plugin_dir_url(__FILE__) . '../assets/js/services-tabs.js');
        wp_enqueue_style('delinternet-services-tabs-css', plugin_dir_url(__FILE__) . '../assets/css/services-tabs.css');
    }

    public function get_name()
    {
        return 'delinternet-services-tabs';
    }


    public function get_title()
    {
        return __('Delinternet Services Tabs', 'delinternet-elementor-widgets');
    }

    public function get_icon()
    {
        return 'eicon-products';
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
        return ['delinternet-services-tabs-css'];
    }

    public function get_script_depends()
    {
        return ['delinternet-services-tabs-js'];
    }


    // Frontend
    protected function render()
    {
        ?>
        <div>Service Tabs widget</div>
    <?php
    }

    protected function _content_template()
    {

        ?>
      <div>Service Tabs widget</div>
    <?php
    }
}