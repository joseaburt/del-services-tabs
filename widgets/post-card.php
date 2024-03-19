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

class DelPostCardWidget extends Widget_Base
{

    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts()
    {
        wp_enqueue_script('delinternet-post-card-js', plugin_dir_url(__FILE__) . '../assets/js/post-card.js');
        wp_enqueue_style('delinternet-post-card-css', plugin_dir_url(__FILE__) . '../assets/css/post-card.css');
    }

    public function get_name()
    {
        return 'delinternet-post-card';
    }


    public function get_title()
    {
        return __('Post Card', 'delinternet-elementor-widgets');
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


    protected function render()
    {
        $args = array('post_type' => 'post', 'posts_per_page' => 3);
        $query = new WP_Query($args);

?>

        <div class="posts-container" style="--grid-columns: 3;">

            <?php

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    $post_date = get_post_time('U', true);
                    $current_time = current_time('timestamp');
                    $time_diff = $current_time - $post_date;

                    $minute = 60;
                    $hour = $minute * 60;
                    $day = $hour * 24;

                    if ($time_diff < $minute) {
                        $time_ago = sprintf(_n('%s second ago', '%s seconds ago', $time_diff, 'text-domain'), $time_diff);
                    } elseif ($time_diff < $hour) {
                        $time_ago = sprintf(_n('%s minute ago', '%s minutes ago', floor($time_diff / $minute), 'text-domain'), floor($time_diff / $minute));
                    } elseif ($time_diff < $day) {
                        $time_ago = sprintf(_n('%s hour ago', '%s hours ago', floor($time_diff / $hour), 'text-domain'), floor($time_diff / $hour));
                    } else {
                        $time_ago = sprintf(_n('%s day ago', '%s days ago', floor($time_diff / $day), 'text-domain'), floor($time_diff / $day));
                    }

            ?>
                    <a href="<?php the_permalink() ?>">
                        <div style="--post-thumbnail-url: url('<?php echo the_post_thumbnail_url(); ?>');" class="post-item-container">
                            <div class="post-content">
                                <div>
                                    <p class="post-date"><?php echo $time_ago; ?></p>
                                    <h6 class="post-title"><?php echo the_title(); ?></h6>
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
