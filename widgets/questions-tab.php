<?php

namespace Delinternet\Plugins\Widgets;

/*
 * Widget Name:       Delinternet Question Container
 * Description:       This is a component to render a set of grouped questions.
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 */



use Elementor\Widget_Base;

class QuestionsTabWidget extends Widget_Base
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

        wp_enqueue_script('delinternet-questions-tab-js', plugin_dir_url(__FILE__) . '../assets/js/questions-tab.js');
        wp_enqueue_style('delinternet-questions-tab-css', plugin_dir_url(__FILE__) . '../assets/css/questions-tab.css');
    }

    public function get_name()
    {
        return 'delinternet-questions-tab';
    }


    public function get_title()
    {
        return __('Questions Tab', 'delinternet-elementor-widgets');
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
        return ['delinternet-services-tabs-css'];
    }

    public function get_script_depends()
    {
        return ['delinternet-services-tabs-js'];
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
            'tab_title',
            [
                'label' => __('Tab Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );


        $questionItemsRepeater = new \Elementor\Repeater();


        $questionItemsRepeater->add_control(
            'question_title',
            [
                'label' => __('Question Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );

        $questionItemsRepeater->add_control(
            'question_details',
            [
                'label' => __('Question Details', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'questions',
            [
                'label' => __('Tab Questions Items', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $questionItemsRepeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ question_title }}}',
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => __('Tabs', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => __('Telefonia Fija', 'plugin-domain'),
                        'questions' => [
                            0 => [
                                'question_title' => __('Item #1', 'plugin-domain'),
                                'question_details' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse malesuada lacus ex, sit amet blandit leo lobortis eget.', 'plugin-domain'),
                            ]
                        ]
                    ],
                    [
                        'tab_title' => __('Fibra Optica', 'plugin-domain'),
                        'questions' => [
                            0 => [
                                'question_title' => __('Item #1', 'plugin-domain'),
                                'question_details' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse malesuada lacus ex, sit amet blandit leo lobortis eget.', 'plugin-domain'),
                            ]
                        ]
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );


        $this->end_controls_section();
    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();
        $tabs = $settings['list'];
        $counter = 1;

?>
        <div id="questions-tab-container" data-selectedTabId="1">
            <div class="questions-tab-header-container">
                <div class="tabs-container">
                    <button class="action-btn" id="pre-tabs-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>
                    <div class="tabs-container2">
                        <ul id="questions-tab-header">
                            <?php foreach ($tabs as $tab) : ?>
                                <li class="questions-tab-item" data-tabItemId="<?php echo $counter; ?>">
                                    <button>
                                        <?php echo $tab['tab_title']; ?>
                                    </button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div id="tabs-indicator"></div>
                    </div>
                    <button class="action-btn" id="next-tabs-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </div>
            </div>
            <?php foreach ($tabs as $tab) : ?>
                <section class="questions-tab-tab-content" id="tab-content-<?php echo $counter; ?>" data-id="<?php echo $counter++; ?>">
                    <ul id="tabs-accordion-container">
                        <?php foreach ($tab['questions'] as $question) : ?>
                            <li class="tabs-accordion-item" data-isSummaryVisible="false">
                                <button class="tabs-accordion-summary">
                                    <span id="open-btn-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                                            <path d="M5 12h14" />
                                            <path d="M12 5v14" />
                                        </svg>
                                    </span>
                                    <span id="close-btn-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                                            <path d="M18 6 6 18" />
                                            <path d="m6 6 12 12" />
                                        </svg>
                                    </span>
                                    <?php echo $question['question_title']; ?>
                                </button>
                                <div class="tabs-accordion-details">
                                    <?php echo  $question['question_details']; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endforeach; ?>
        </div>
<?php
    }
}
