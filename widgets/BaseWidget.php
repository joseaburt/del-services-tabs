
<?php

namespace Delinternet\Plugins\Widgets;

use Elementor\Widget_Base;

class BaseWidget extends Widget_Base
{
    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
        $this->init_common_scripts();
    }


    protected function init_common_scripts()
    {
        wp_enqueue_script('delinternet-base-widget-js', plugin_dir_url(__FILE__) . '../assets/js/base-widget.js');
        wp_enqueue_script('delinternet-utils-js', plugin_dir_url(__FILE__) . '../assets/js/utils.js');
        wp_enqueue_style('delinternet-event-bus-js', plugin_dir_url(__FILE__) . '../assets/css/event-bus.js');
    }
}
