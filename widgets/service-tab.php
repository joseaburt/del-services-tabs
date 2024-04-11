<?php

/*
 * Widget Name:       Delinternet Services Packs Tabs
 * Description:       This is a component to render Delinternet Services Packs Tabs
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 */

namespace Delinternet\Plugins\Widgets;

use Elementor\Widget_Base;


class DelinternetServiceTabWidget extends Widget_Base
{
    public function __construct($data = array(), $args = array())
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts()
    {
        wp_enqueue_script('del-commons-js', plugin_dir_url(__FILE__) . '../assets/js/del-commons.js');

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


    public function _register_controlsX()
    {
    }

    public function _register_controls()
    {
        $this->start_controls_section(
            'TabSections',
            [
                'label' => __('TabSections', 'my-elementor-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );


        $mainRepeater = new \Elementor\Repeater();


        $mainRepeater->add_control(
            'tab_title',
            [
                'label' => __('Tab Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Pricing Title', 'plugin-domain'),
                'label_block' => true,
                'placeholder' => __('Type your title here', 'plugin-domain'),
            ]
        );


        $tabServicesCardsRepeater = new \Elementor\Repeater();


        // Card Theme
        $tabServicesCardsRepeater->add_control(
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

        // Card Title
        $tabServicesCardsRepeater->add_control(
            'card_title',
            [
                'label' => __('Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Pricing Title', 'plugin-domain'),
                'label_block' => true,
                'placeholder' => __('Type your title here', 'plugin-domain'),
            ]
        );

        // Card Price


        $tabServicesCardsRepeater->add_control(
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


        $tabServicesCardsRepeater->add_control(
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

        $tabServicesCardsRepeater->add_control(
            'previous_price',
            [
                'label' => __('Previous Price', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('20.99', 'plugin-domain'),
                'label_block' => true,
                'placeholder' => __('Type your price here', 'plugin-domain'),
                'condition' => [
                    'show_prices' => 'yes'
                ]
            ]
        );

        $tabServicesCardsRepeater->add_control(
            'new_price',
            [
                'label' => __('New Price', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('12.45', 'plugin-domain'),
                'label_block' => true,
                'placeholder' => __('Type your new price here', 'plugin-domain'),
                'condition' => [
                    'show_prices' => 'yes'
                ]
            ]
        );

        $tabServicesCardsRepeater->add_control(
            'price_details',
            [
                'label' => __('Price Details', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('per mes', 'plugin-domain'),
                'label_block' => true,
                'placeholder' => __('Type the price details here', 'plugin-domain'),
            ]
        );



        $cardFeaturesRepeater = new \Elementor\Repeater();

        $cardFeaturesRepeater->add_control(
            'feature_text',
            [
                'label' => __('Feature Text', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );




        $tabServicesCardsRepeater->add_control(
            'list',
            [
                'label' => __('Card Features List', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $cardFeaturesRepeater->get_controls(),
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

        $tabServicesCardsRepeater->add_control(
            'button_text',
            [
                'label_block' => true,
                'label' => __('Button Text', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Llámanos', 'plugin-domain'),
            ]
        );

        $tabServicesCardsRepeater->add_control(
            'button_link',
            [
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => __('#', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label' => __('Button Link', 'plugin-domain'),
            ]
        );



        $mainRepeater->add_control(
            'tab_service_cards',
            [
                'default' => [],
                'label' => __('Service Card', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $tabServicesCardsRepeater->get_controls(),
                'title_field' => '{{{ card_title }}}',
            ]
        );



        $this->add_control(
            'services',
            [
                'default' => [],
                'fields' => $mainRepeater->get_controls(),
                'label' => __('Services', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'title_field' => '{{{ tab_title }}}',
            ]
        );



        $this->end_controls_section();
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

        $services = $settings['services'];
?>
        <div class="del-service-tabs-widget-container">

            <?php if (count($services) > 1) : ?>
                <div id="del-service-tabs-container-id" class="del-service-tabs-container">
                    <?php
                    $tabCounter = 0;
                    foreach ($services as $tab) :
                        $tabCounter++;
                    ?>
                        <button data-tab-id="<?php echo  $tabCounter; ?>" id="service-tab-<?php echo  $tabCounter; ?>" class="tab-btn">
                            <?php echo  $tab['tab_title']; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div id="del-service-content-sections-container-id" class="del-service-content-sections-container">
                <?php
                $tabCounterSection = 0;
                foreach ($services as $tab) :
                    $tabCounterSection++;
                ?>
                    <section data-tab-content-id="<?php echo  $tabCounterSection; ?>" id="service-tab-content-<?php echo  $tabCounterSection; ?>" class="">
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
                            <?php foreach ($tab['tab_service_cards'] as $card_props) : ?>
                                <div class="service-pack-card_<?php echo $card_props['card_type']; ?>_theme">
                                    <div class="service-pack-card-container" style="max-width: 300px;">
                                        <div class="service-pack-card-inner-container">
                                            <div class="service-pack-card-header">
                                                <h2 class="header-title text-center"><?php echo $card_props['card_title']; ?></h2>
                                            </div>
                                            <div class="service-pack-card-price">
                                                <?php if ('yes' == $card_props['show_prices']) : ?>
                                                    <div class="service-pack-card-price-amounts">
                                                        <div class="previous_price">
                                                            <small>€</small>
                                                            <del class="amount">
                                                                <?php echo $card_props['previous_price']; ?>
                                                            </del>
                                                        </div>
                                                        <div class="new_price">
                                                            <small>€</small>
                                                            <span class="amount">
                                                                <?php echo $card_props['new_price']; ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if ('yes' != $card_props['show_prices']) : ?>
                                                    <span class="custom_price_value">
                                                        <?php echo $card_props['custom_price_value']; ?>
                                                    </span>
                                                <?php endif; ?>
                                                <p class="price_details">
                                                    <?php echo $card_props['price_details']; ?>
                                                </p>
                                            </div>
                                            <div class="divider border-t <?php echo $card_props['card_type'] == 'light' ? '' : 'border-slate-700' ?>">
                                                <hr class="border">
                                            </div>
                                            <div class="service-pack-card-features">
                                                <?php foreach ($card_props['list'] as $item) : ?>
                                                    <div style="display: flex; align-items: center; gap: 10px;">
                                                        <span style="color: var(--e-global-color-primary);">
                                                            <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9">
                                                                <path d="M301.439,37.44,296.5,42.379l-1.939-1.939a1.5,1.5,0,1,0-2.121,2.121l3,3a1.5,1.5,0,0,0,2.121,0l6-6a1.5,1.5,0,0,0-2.121-2.121Z" transform="translate(-292 -37)"></path>
                                                            </svg>
                                                        </span>
                                                        <?php echo $item['feature_text']; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="service-pack-card-action" style="background: <?php $card_props['background_background']; ?>">
                                                <a href="<?php echo $card_props['button_link']; ?>" class="button-pricing-action">
                                                    <?php echo $card_props['button_text']; ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>
<?php
    }
}
