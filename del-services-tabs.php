<?php

/*
 * Plugin Name:       Delinternet Services Tabs
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       This plugin show a collection of card that represent a service of the company.
 * Version:           0.1.0
 * Requires PHP:      0.1.0
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 * Text Domain:       del-plugins
 * Domain Path:       /languages
 */


namespace Delinternet\Plugins;

use Delinternet\Plugins\Widgets\Nav_Menu;
use Delinternet\Plugins\Widgets\DelinternetServiceTabWidget;
use Delinternet\Plugins\Widgets\DelPostCardWidget;
use Delinternet\Plugins\Widgets\RelatedPostsWidget;
use Delinternet\Plugins\Widgets\AccordionWidget;
use Delinternet\Plugins\Widgets\DecoratedHeadingWidget;
use Delinternet\Plugins\Widgets\FooterWidget;
use Delinternet\Plugins\Widgets\QuestionsTabWidget;
use Delinternet\Plugins\Widgets\ReviewsWidget;

if (!defined('ABSPATH')) {
    exit;
}


final class DelServicesTabsWidget
{
    const VERSION = '0.1.0';
    const ELEMENTOR_MINIMUN_VERSION = '3.0.0';
    const PHP_MINIMUN_VERSION = '7.0';

    private static $_instance = null;

    public function __construct()
    {
        add_action('this', [$this, 'i18n']);
        add_action('plugins_loaded', [$this, 'init_plugin']);
        add_action('elementor/elements/categories_registered', [$this, 'create_new_category']);
        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
    }

    public function i18n()
    {
        load_plugin_textdomain("del-plugins");
    }

    public function init_controls()
    {
    }

    public function init_plugin()
    {
        // check version php version
        // Check elementor installation
        // bring in the widget classes
        // bring in the controls
    }

    public function init_widgets()
    {
        require_once __DIR__ . '/widgets/nav-menu.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Nav_Menu());

        require_once __DIR__ . '/widgets/service-tab.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DelinternetServiceTabWidget());



        require_once __DIR__ . '/widgets/post-card.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DelPostCardWidget());


        require_once __DIR__ . '/widgets/related-posts.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new RelatedPostsWidget());

        require_once __DIR__ . '/widgets/accordion.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new AccordionWidget());


        require_once __DIR__ . '/widgets/questions-tab.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new QuestionsTabWidget());


        require_once __DIR__ . '/widgets/decorated-heading.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DecoratedHeadingWidget());


        require_once __DIR__ . '/widgets/reviews-widget.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new ReviewsWidget());

        require_once __DIR__ . '/widgets/footer-widget.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new FooterWidget());
    }

    public function create_new_category($elements_manager)
    {

        $elements_manager->add_category(
            'delinternet',
            [
                'title' => __('Delinternet', 'delinternet-elementor-widgets'),
                'icon'  => 'fa fa-plug'
            ],
            1
        );
    }


    // ===============================================
    // Singleton
    // ===============================================

    public static function get_instance()
    {
        if (null == self::$_instance) {
            self::$_instance = new Self();
        }
        return self::$_instance;
    }
}



DelServicesTabsWidget::get_instance();
