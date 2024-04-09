<?php
/*
 * Widget Name:       Delinternet Post Card
 * Description:       This is a component to render a set of posts.
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 */

namespace Delinternet\Plugins\Widgets;

use WP_Query;
use Elementor\Widget_Base;
use Delinternet\Plugins\Utils\DateFormatter;
use Delinternet\Plugins\Utils\StringFormatter;

require_once __DIR__ . '/../utils/string-formatter.php';
require_once __DIR__ . '/../utils/date-formatter.php';

class RelatedPostsWidget extends Widget_Base
{

    public function __construct($data = array(), $args = array())
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts()
    {
        wp_enqueue_script('delinternet-event-bus-js', plugin_dir_url(__FILE__) . '../assets/js/event-bus.js');
        wp_enqueue_script('delinternet-base-widget-js', plugin_dir_url(__FILE__) . '../assets/js/base-widget.js');
        wp_enqueue_script('delinternet-utils-js', plugin_dir_url(__FILE__) . '../assets/js/utils.js');

        wp_enqueue_script('delinternet-related-posts-js', plugin_dir_url(__FILE__) . '../assets/js/related-posts.js');
        wp_enqueue_style('delinternet-related-posts-css', plugin_dir_url(__FILE__) . '../assets/css/related-posts.css');
    }

    public function get_name()
    {
        return 'delinternet-related-posts';
    }


    public function get_title()
    {
        return __('Related Posts', 'delinternet-elementor-widgets');
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
        return ['delinternet-related-posts-css'];
    }

    public function get_script_depends()
    {
        return ['delinternet-related-posts-js'];
    }

    public function _register_controls()
    {
        $this->start_controls_section(
            'posts_section',
            [
                'label' => __('Post Settings', 'my-elementor-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'number_of_posts',
            [
                'label' => __('Number of posts to show', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'label_block' => true,
                'placeholder' => __('Type the number of post to show', 'plugin-domain'),
            ]
        );


        $this->add_control(
            'post_title_lenght',
            [
                'label' => __('Post Title length', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 58,
                'label_block' => true,
                'placeholder' => __('Type the lenght of the post title', 'plugin-domain'),
            ]
        );


        $this->add_control(
            'post_card_orientation',
            [
                'label' => __('Post Card Orientation', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'label_block' => true,
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'textdomain'),
                    'vertical' => esc_html__('Vertical', 'textdomain'),

                ],
            ]
        );

        $this->add_control(
            'search_post_text',
            [
                'label' => __('Post Title length', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => "",
                'label_block' => true,
                'placeholder' => __('Type the search criteria', 'plugin-domain'),
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $num_of_post_to_show = $settings['search_post_text'];
        $num_of_post_to_show = $settings['number_of_posts'];
        $args = array('post_type' => 'post', 'posts_per_page' => $num_of_post_to_show);
        $query = new WP_Query($args);
        $post_card_orientation = $settings['post_card_orientation'];
        $grid_columns = $num_of_post_to_show;

        if ('vertical' == $post_card_orientation) {
            $grid_columns = 1;
        }
?>
        <div class="related-post-container related-post-<?php echo $post_card_orientation; ?>-container" style="--grid-columns: <?php echo $grid_columns; ?>;">
            <?php
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $post_date = get_post_time('U', true);
                    $current_time = current_time('timestamp');
                    $time_diff = $current_time - $post_date;
                    $time_ago = DateFormatter::fromNow($time_diff);
                    $post_title = StringFormatter::shortText(the_title("", "", false), $settings['post_title_lenght']);
            ?>
                    <a href="<?php the_permalink() ?>">
                        <div class="related-post-item-container <?php echo "horizontal" == $post_card_orientation ?  'realted-post-item-horizontal-container' : 'realted-post-item-vertial-container' ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="related-post-thumbnail">
                                    <?php the_post_thumbnail("large"); ?>
                                </div>
                            <?php endif; ?>
                            <div class="related-post-content">
                                <div>
                                    <h6 class="related-post-title"><?php echo $post_title; ?></h6>
                                    <p class="realted-post-date"><?php echo $time_ago; ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
            <?php }
                wp_reset_postdata();
            } else {
                echo 'No posts found';
            }
            ?>

        </div>

<?php

    }
}
