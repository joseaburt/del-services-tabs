<?php
/*
 * Widget Name:       Delinternet footer-widget Widget
 * Description:       This is a component to render footer-widget
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 */

namespace Delinternet\Plugins\Widgets;

use Elementor\Widget_Base;


class FooterWidget extends Widget_Base
{
    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts()
    {
        wp_enqueue_script('delinternet-event-bus-js', plugin_dir_url(__FILE__) . '../assets/js/event-bus.js');
        wp_enqueue_script('delinternet-base-widget-js', plugin_dir_url(__FILE__) . '../assets/js/base-widget.js');
        wp_enqueue_script('delinternet-utils-js', plugin_dir_url(__FILE__) . '../assets/js/utils.js');
        
        wp_enqueue_script('del-footer-widget-js', plugin_dir_url(__FILE__) . '../assets/js/footer-widget.js');
        wp_enqueue_style('del-footer-widget-css', plugin_dir_url(__FILE__) . '../assets/css/footer-widget.css');
    }

    public function get_name()
    {
        return 'del-footer-widget';
    }


    public function get_title()
    {
        return __('FooterWidget', 'delinternet-elementor-widgets');
    }

    public function get_icon()
    {
        return 'eicon-products';
    }

    public function get_categories()
    {
        return ['delinternet'];
    }


    public function _register_controls()
    {}

    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="del-footer-widget" id="del-footer-widget-id">
            Code your widget here.
        </div>
<?php
    }
}
