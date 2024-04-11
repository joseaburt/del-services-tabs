<?php
/*
 * Widget Name:       Delinternet service-card-widget Widget
 * Description:       This is a component to render service-card-widget
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 */

namespace Delinternet\Plugins\Widgets;

use Elementor\Widget_Base;


class ServiceCardWidget extends Widget_Base
{
    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts()
    {
        wp_enqueue_script('del-commons-js', plugin_dir_url(__FILE__) . '../assets/js/del-commons.js');

        wp_enqueue_script('del-service-card-widget-js', plugin_dir_url(__FILE__) . '../assets/js/service-card-widget.js');
        wp_enqueue_style('del-service-card-widget-css', plugin_dir_url(__FILE__) . '../assets/css/service-card-widget.css');
    }

    public function get_name()
    {
        return 'del-service-card-widget';
    }


    public function get_title()
    {
        return __('ServiceCardWidget', 'delinternet-elementor-widgets');
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
    {
        $this->start_controls_section(
            'General',
            [
                'label' => __('General', 'my-elementor-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],


            ]
        );
        $this->add_control(
            'title',
            [
                'label' => __('Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Service Name', 'plugin-domain'),
                'label_block' => true,

            ]
        );
        $this->add_control(
            'description',
            [
                'label' => __('Description', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Service Description here', 'plugin-domain'),
                'label_block' => true,

            ]
        );
        $this->add_control(
            'show_see_more_button',
            [
                'label' => __('Show See More Button', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => __('true', 'plugin-domain'),
                'label_block' => true,

            ]
        );
        $this->add_control(
            'show_more_button_text',
            [
                'label' => __('See More Button Text', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('More', 'plugin-domain'),
                'label_block' => true,

            ]
        );
        $this->add_control(
            'show_more_button_url',
            [
                'label' => __('See More Button Url', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('true', 'plugin-domain'),
                'label_block' => true,

            ]
        );
        $this->end_controls_section();
    }



    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $icon = $settings['icon']['url'];
        $title = $settings['title'];
        $description = $settings['description'];
        $show_see_more_button = $settings['show_see_more_button'];
        $show_more_button_text = $settings['show_more_button_text'];
        $show_more_button_url = $settings['show_more_button_url'];
?>
        <div class="del-service-card-widget w-full h-full rounded-2xl shadow-sm px-12 py-8 flex flex-col gap-2 items-center justify-between flex-wrap border border-slate-400" style="background-color: #FEFEFA; height: 100%; width: 100%;" id="del-service-card-widget-id">
            <div class="flex flex-col gap-4 items-center">
                <div class="w-16 h-16 flex justify-center items-center">
                    <img src="<?php echo $icon; ?>" alt="delinternet-service-item" class="h-full">
                </div>
                <div class="flex flex-col gap-0 items-center text-center">
                    <h2 class="text-lg font-bold text-slate-700 font-sans m-0 mb-0 text-center">
                        <?php echo $title; ?>
                    </h2>
                    <p class="text-md text-slate-900 font-sans text-center">
                        <?php echo $description; ?>
                    </p>
                </div>
            </div>
            <?php if ('yes' != $show_see_more_button) : ?>
                <a href="<?php echo $show_more_button_url; ?>" class="rounded-full px-3 py-2 flex items-center gap-1 show_more_button">
                    <?php echo $show_more_button_text; ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>
<?php
    }
}
