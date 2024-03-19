<?php

namespace Delinternet\Plugins\Widgets;

use Elementor\Widget_Base;


class DelinternetServiceTabWidget extends Widget_Base
{
    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts()
    {
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

    public function _register_controls()
    {

        // Card Type
        $this->start_controls_section(
            'card_type_section',
            [
                'label' => __('Card Type', 'my-elementor-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Title
        $this->add_control(
            'card_type',
            [
                'label' => __('Card Type', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'light',
                'label_block' => true,
                'options' => [
                    'light' => esc_html__('Light', 'textdomain'),
                    'dark' => esc_html__('Dark', 'textdomain'),

                ],
                'placeholder' => __('Type your title here', 'plugin-domain'),
            ]
        );


        $this->end_controls_section();








        // Header Settings
        $this->start_controls_section(
            'header_section',
            [
                'label' => __('Header', 'my-elementor-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Title
        $this->add_control(
            'header_title',
            [
                'label' => __('Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Pricing Title', 'plugin-domain'),
                'label_block' => true,
                'placeholder' => __('Type your title here', 'plugin-domain'),
            ]
        );





        // Show Badge
        $this->add_control(
            'show_badge',
            [
                'label' => __('Show Badge', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'your-plugin'),
                'label_off' => __('Hide', 'your-plugin'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );



        $this->end_controls_section();

        // Price Settings
        $this->start_controls_section(
            'price_section',
            [
                'label' => __('Pricing', 'my-elementor-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'show_prices',
            [
                'label' => __('Show Prices', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'your-plugin'),
                'label_off' => __('Hide', 'your-plugin'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );





        $this->add_control(
            'custom_price_value',
            [
                'label' => __('Text instead prices', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Adecuado', 'plugin-domain'),
                'label_block' => true,
                'placeholder' => __('Type your title here', 'plugin-domain'),
                'condition' => [
                    'show_prices' => ''
                ]
            ]
        );




        // Previous Pack Price
        $this->add_control(
            'previous_price',
            [
                'label' => __('Previous Price', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('$20.99', 'plugin-domain'),
                'label_block' => true,
                'placeholder' => __('Type your price here', 'plugin-domain'),
                'condition' => [
                    'show_prices' => 'yes'
                ]
            ]
        );

        // New Pack Price




        $this->add_control(
            'new_price',
            [
                'label' => __('New Price', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('year', 'plugin-domain'),
                'label_block' => true,
                'placeholder' => __('Type your new price here', 'plugin-domain'),
                'condition' => [
                    'show_prices' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'price_details',
            [
                'label' => __('Price Details', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('per mes', 'plugin-domain'),
                'label_block' => true,
                'placeholder' => __('Type the price details here', 'plugin-domain'),
            ]
        );




        $this->end_controls_section();

        // Listing Settings
        $this->start_controls_section(
            'listing_section',
            [
                'label' => __('Listing', 'my-elementor-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );


        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'feature_text',
            [
                'label' => __('Feature Text', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'feature_icon',
            [
                'label' => __('Feature Icon', 'text-domain'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'solid',
                ],
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
                        'feature_text' => __('upto 5 users', 'plugin-domain'),
                    ],
                    [
                        'feature_text' => __('max 100 items/month', 'plugin-domain'),
                    ],
                    [
                        'feature_text' => __('500 quries', 'plugin-domain'),
                    ],
                    [
                        'feature_text' => __('basic statistic', 'plugin-domain'),
                    ],
                ],
                'title_field' => '{{{ feature_text }}}',
            ]
        );

        $this->end_controls_section();



        // Button Settings
        $this->start_controls_section(
            'button_section',
            [
                'label' => __('Button', 'my-elementor-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );



        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Llámanos', 'plugin-domain'),
                'label_block' => true,
            ]
        );


        $this->add_control(
            'button_link',
            [
                'label' => __('Button Link', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('#', 'plugin-domain'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .your-class',
            ]
        );




        $this->end_controls_section();

        // Style Tab
        $this->style_tab();
    }

    private function style_tab()
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
        $settings = $this->get_settings_for_display();



?>
        <div class="service-pack-card_<?php echo $settings['card_type']; ?>_theme">
            <div class="service-pack-card-container">
                <div class="service-pack-card-inner-container">

                    <div class="service-pack-card-header">
                        <h2 class="header-title"><?php echo $settings['header_title']; ?></h2>
                    </div>

                    <div class="service-pack-card-price">

                        <?php if ('yes' == $settings['show_prices']) : ?>
                            <div class="service-pack-card-price-amounts">
                                <div class="previous_price">
                                    <small>€</small>
                                    <del class="amount">
                                        <?php echo $settings['previous_price']; ?>
                                    </del>
                                </div>
                                <div class="new_price">
                                    <small>€</small>
                                    <span class="amount">
                                        <?php echo $settings['new_price']; ?>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php if ('yes' != $settings['show_prices']) : ?>
                            <span class="custom_price_value">
                                <?php echo $settings['custom_price_value']; ?>
                            </span>
                        <?php endif; ?>


                        <p class="price_details">
                            <?php echo $settings['price_details']; ?>
                        </p>
                    </div>
                    <div class="divider">
                        <hr>
                    </div>
                    <div class="service-pack-card-features">
                        <?php foreach ($settings['list'] as $item) : ?>
                            <div><?php \Elementor\Icons_Manager::render_icon($item['feature_icon'], ['aria-hidden' => 'true']); ?> <?php echo $item['feature_text']; ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="service-pack-card-action" style="background: <?php $settings['background_background']; ?>">
                        <a href="<?php echo $settings['button_link']; ?>" class="button-pricing-action">
                            <?php echo $settings['button_text']; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
<?php
    }

    // protected function _content_template()
    // {
    // }
}
