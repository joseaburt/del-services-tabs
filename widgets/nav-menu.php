<?php
/*
 * Widget Name:       Delinternet Navbar
 * Description:       This is a component to render navbar
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 */

namespace Delinternet\Plugins\Widgets;

use Elementor\Widget_Base;

/**
 * Have the widget code for the Custom Elementor Nav Menu.
 */

class Nav_Menu extends Widget_Base
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

        wp_enqueue_script('delinternet-menu-js', plugin_dir_url(__FILE__) . '../assets/js/menu.js');
        wp_enqueue_style('delinternet-menu-css', plugin_dir_url(__FILE__) . '../assets/css/menu.css');
    }

    public function get_name()
    {
        return 'delinternet-menu';
    }


    public function get_title()
    {
        return __('Delinternet Menu', 'delinternet-elementor-widgets');
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
        return ['delinternet-menu-css'];
    }

    public function get_script_depends()
    {
        return ['delinternet-menu-js'];
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
            'image',
            [
                'label' => esc_html__('Choose Image', 'textdomain'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );


        $this->add_control(
            'contactPhone',
            [
                'label' => __('Contact Phone', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );


        $this->add_control(
            'shallWeCallYouBtnText',
            [
                'label' => __('Shall We Call You Button Text', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );


        $this->add_control(
            'companyPhoneNumber',
            [
                'label' => __('Item Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'NavigationMenu',
            [
                'label' => __('Navigation Menu', 'my-elementor-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );



        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __('Item Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );


        $repeater->add_control(
            'url',
            [
                'label' => __('Item Url', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );


        $subMenuRepeater = new \Elementor\Repeater();
        $subMenuRepeater->add_control(
            'title',
            [
                'label' => __('Item Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );
        $subMenuRepeater->add_control(
            'url',
            [
                'label' => __('Item Url', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
            ]
        );



        $repeater->add_control(
            'subMenu',
            [
                'label' => __('SubMenu', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $subMenuRepeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ title }}}',
            ]
        );





        $this->add_control(
            'list',
            [
                'label' => __('Repeater List', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $menu = $settings['list'];
        $logo = $settings['image'];
        $contactPhone = $settings['contactPhone'];
        $shallWeCallYouBtnText = $settings['shallWeCallYouBtnText'];



?>

        <div class="delinternet-man-navbar">
            <div class="elementor-element e-con-boxed e-con">
                <div class="e-con-inner main-del-navbar">
                    <div class="left-side">
                        <a href="/" class="logo-anchor">
                            <img class="logo-img" src="<?php echo $logo["url"]; ?>" alt="<?php echo $logo["alt"]; ?>">
                        </a>
                        <ul class="main-del-menu-ul-container">
                            <?php foreach ($menu as $item) : ?>
                                <li class="main-del-menu-il<?php echo empty($item['subMenu']) ? '' : ' with-submenu-main-del-menu-il'; ?>">
                                    <?php if (empty($item['subMenu'])) : ?>
                                        <a class="menu-anchor" href="<?php echo $item['url']; ?>">
                                            <?php echo $item['title']; ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($item['subMenu'])) : ?>
                                        <p class="menu-anchor">
                                            <?php echo $item['title']; ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if (!empty($item['subMenu'])) : ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down">
                                            <path d="m6 9 6 6 6-6" />
                                        </svg>
                                    <?php endif; ?>
                                    <?php if (!empty($item['subMenu'])) : ?>
                                        <ul class="main-del-submenu-ul-container">
                                            <?php foreach ($item['subMenu'] as $subItem) : ?>
                                                <li class="main-del-submenu-il">
                                                    <a class="menu-anchor" href="<?php echo $subItem['url']; ?>">
                                                        <?php echo $subItem['title']; ?>
                                                    </a>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
                                                        <path d="m9 18 6-6-6-6" />
                                                    </svg>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="right-side">
                        <a class="menu-anchor" href="tel:<?php echo preg_replace('/\s+/', '', $contactPhone); ?>">
                            Llama: <b><?php echo $contactPhone; ?></b>
                        </a>
                        <button>
                            <?php echo $shallWeCallYouBtnText; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
