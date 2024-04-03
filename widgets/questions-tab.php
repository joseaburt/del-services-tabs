<?php

/*
 * Widget Name:       Delinternet Question Container
 * Description:       This is a component to render a set of grouped questions.
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 */

namespace Delinternet\Plugins\Widgets;

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



        // ===============================




        // ===============================
    }

    protected function render()
    {

        $tab_count = 30;

        $tabs = array();

        for ($i = 1; $i <= $tab_count; $i++) {
            $tabs[] = $i;
        }
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
                                <li class="questions-tab-item" data-tabItemId="<?php echo $tab; ?>">
                                    <button>
                                        Tab # <?php echo $tab; ?>
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
                <section class="questions-tab-tab-content" id="tab-content-<?php echo $tab; ?>" data-id="<?php echo $tab; ?>">
                    <h4>This is section for # <?php echo $tab; ?></h4>
                    <br>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis ligula sit amet nunc sodales laoreet ut et sem. In pulvinar, lorem eget laoreet fermentum, neque lorem lobortis tellus, in bibendum augue ex ac elit. Aliquam tincidunt quam quis pharetra eleifend. Etiam est velit, aliquam sed auctor a, suscipit et elit. Morbi vitae sem consequat, blandit lacus ac, vehicula mi. Phasellus luctus enim non metus tempor, quis condimentum justo sollicitudin. Nunc at mi lacus. Morbi arcu enim, facilisis sed venenatis ac, luctus faucibus nibh. Donec feugiat a dui ut commodo. Praesent tristique, libero at pulvinar egestas, leo purus pharetra enim, ut fringilla ipsum sapien eget nulla. Praesent posuere vitae turpis ut egestas.
                    </p>
                </section>
            <?php endforeach; ?>
        </div>
<?php
    }
}
