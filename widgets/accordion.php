<?php
/*
 * Widget Name:       Delinternet Accordion
 * Description:       This is a component to render an accordion.
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 */

namespace Delinternet\Plugins\Widgets;


use Elementor\Widget_Base;


class AccordionWidget extends Widget_Base
{



    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts()
    {
        wp_enqueue_script('delinternet-accordion-js', plugin_dir_url(__FILE__) . '../assets/js/accordion.js');
        wp_enqueue_style('delinternet-accordion-css', plugin_dir_url(__FILE__) . '../assets/css/accordion.css');
    }

    public function get_name()
    {
        return 'delinternet-accordion';
    }


    public function get_title()
    {
        return __('Accordion', 'delinternet-elementor-widgets');
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    public function get_categories()
    {
        return ['delinternet'];
    }

    public function get_style_depends()
    {
        return ['delinternet-accordion-css'];
    }

    public function get_script_depends()
    {
        return ['delinternet-accordion-js'];
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


        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'summary_text',
            [
                'label' => __('Summary Text', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'details_text',
            [
                'label' => __('Details Text', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => __('Repeater List', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'summary_text' => __('Item #1', 'plugin-domain'),
                        'details_text' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse malesuada lacus ex, sit amet blandit leo lobortis eget.', 'plugin-domain'),
                    ],
                    [
                        'summary_text' => __('Item #2', 'plugin-domain'),
                        'details_text' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse malesuada lacus ex, sit amet blandit leo lobortis eget.', 'plugin-domain'),
                    ],
                ],
                'title_field' => '{{{ summary_text }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <ul id="accordion-container">
            <?php foreach ($settings['list'] as $item) : ?>
                <li class="accordion-item" data-isSummaryVisible="false">
                    <button class="accordion-summary">
                        <?php echo $item['summary_text']; ?>
                        <span>+</span>
                    </button>
                    <div class="accordion-details">
                        <?php echo $item['details_text']; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

<?php

    }
}
