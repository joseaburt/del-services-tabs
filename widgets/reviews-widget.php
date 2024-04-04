<?php
/*
 * Widget Name:       Delinternet reviews-widget Widget
 * Description:       This is a component to render reviews-widget
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 */

namespace Delinternet\Plugins\Widgets;

use Elementor\Widget_Base;


class ReviewsWidget extends Widget_Base
{
    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts()
    {
        wp_enqueue_script('del-reviews-widget-js', plugin_dir_url(__FILE__) . '../assets/js/reviews-widget.js');
        wp_enqueue_style('del-reviews-widget-css', plugin_dir_url(__FILE__) . '../assets/css/reviews-widget.css');
    }

    public function get_name()
    {
        return 'del-reviews-widget';
    }


    public function get_title()
    {
        return __('Reviews', 'delinternet-elementor-widgets');
    }

    public function get_icon()
    {
        return 'eicon-favorite';
    }

    public function get_categories()
    {
        return ['delinternet'];
    }


    public function _register_controls()
    {
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="del-reviews-widget">
            Code your widget here.
        </div>
<?php
    }
}
