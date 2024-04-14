
<?php

namespace Delinternet\Plugins\Widgets;


class BaseWidget
{
    public static function enqueue_common_scripts()
    {
        wp_enqueue_style('delinternet-event-bus-js', plugin_dir_url(__FILE__) . '../assets/css/event-bus.js');
        wp_enqueue_script('delinternet-base-widget-js', plugin_dir_url(__FILE__) . '../assets/js/base-widget.js');
        wp_enqueue_script('delinternet-utils-js', plugin_dir_url(__FILE__) . '../assets/js/utils.js');
    }
}
