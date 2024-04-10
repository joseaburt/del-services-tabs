<?php
/*
 * Widget Name:       Delinternet Decorated Heading
 * Description:       This is a component to render Decorated Heading
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 */

namespace Delinternet\Plugins\Widgets;

use Elementor\Widget_Base;


class DecoratedHeadingWidget extends Widget_Base
{
    public function __construct($data = array(), $args = array())
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts()
    {
        wp_enqueue_script('del-commons-js', plugin_dir_url(__FILE__) . '../assets/js/del-commons.js');

        wp_enqueue_script('del-decorated-heading-js', plugin_dir_url(__FILE__) . '../assets/js/decorated-heading.js');
        wp_enqueue_style('del-decorated-heading-css', plugin_dir_url(__FILE__) . '../assets/css/decorated-heading.css');
    }

    public function get_name()
    {
        return 'del-decorated-heading';
    }


    public function get_title()
    {
        return __('Delinternet Decorated Heading', 'delinternet-elementor-widgets');
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
            'text',
            [
                'label' => __('Text Value', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Heading Text', 'plugin-domain'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => __('Text Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => "",
                'label_block' => true,
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();


?>
        <div class="del-decorated-heading-container">
            <span>
                <svg xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 124 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="primary-text-adarment d-none d-sm-flex position-absolute top-0 left-0 h-100 mw-100">
                    <path d="M232.544 37.3404H16.3843C9.3543 37.3404 3.6543 31.6404 3.6543 24.6104V17.6304C3.6543 10.6004 9.3543 4.90039 16.3843 4.90039" stroke="url(&quot;#path1712223129&quot;)" stroke-width="4px" stroke-miterlimit="10" stroke-linecap="round" fill="none"></path>
                    <defs>
                        <linearGradient id="path1712223129" x1="-21.0001" y1="15" x2="24.7247" y2="-70.672" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#B9D300"></stop>
                            <stop offset="0.525" stop-color="#DBE87D"></stop>
                            <stop offset="1" stop-color="#E6EFA4"></stop>
                        </linearGradient>
                        <linearGradient id="path1712223129" x1="-21.0001" y1="15" x2="24.7247" y2="-70.672" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#B9D300"></stop>
                            <stop offset="0.525" stop-color="#DBE87D"></stop>
                            <stop offset="1" stop-color="#E6EFA4"></stop>
                        </linearGradient>
                    </defs>
                </svg>
                <svg xmlns:xlink="http://www.w3.org/1999/xlink" width="33" height="34" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="secondary-text-adarment position-absolute top-0 right-0 mt-n1 mr-n1">
                    <path d="M5.59044 13.1618C5.74362 13.317 5.49623 13.5603 4.90371 13.8666C4.64013 13.9865 4.36933 14.056 4.10395 14.0718C3.96105 14.0032 3.82615 13.9197 3.70065 13.8222C3.51586 13.3256 3.36218 12.8094 3.24053 12.2765C3.14444 11.9154 3.10835 11.5248 3.13382 11.1217C3.15755 10.323 3.1754 9.51418 3.25235 8.69985C3.2575 8.52986 3.28744 8.35607 3.34099 8.18525C3.58381 7.56402 3.73563 6.92186 3.78964 6.28761C3.81432 6.18325 3.83899 6.07888 3.76619 5.96778C3.69339 5.85669 4.08487 4.06119 4.27541 3.81397C4.64109 3.27991 4.94178 2.74136 5.31334 2.21734C5.33129 2.14144 5.35372 2.04655 5.4949 2.00808C5.80977 1.93336 5.87451 1.76426 5.98576 1.608C6.13202 1.37203 6.32469 1.17218 6.5436 1.02933C6.68686 0.956698 6.83324 0.898967 6.98062 0.856968C7.1078 0.807882 7.27274 0.983186 7.28589 1.03231C7.29905 1.08143 7.45393 1.15961 7.55056 1.20485L7.65616 1.21213C7.63821 1.28803 7.89053 2.66508 7.87622 2.76052C7.6952 3.37522 7.56503 3.99598 7.48752 4.61407C7.46509 4.70895 7.44266 4.80383 7.33899 4.89311C7.23533 4.98239 7.21092 6.27285 7.18934 6.32922C7.12428 6.60438 7.14046 6.88513 6.85159 7.16414C6.79752 7.21827 6.82468 7.278 6.81122 7.33493C6.72806 7.82666 6.61181 8.31836 6.46351 8.80559C6.415 9.05822 6.38292 9.31065 6.36753 9.56076C6.36753 9.56076 6.34509 9.65564 6.33388 9.70308C6.31195 9.76229 6.29758 9.82307 6.29126 9.88335C6.20196 10.4843 6.16018 11.0817 6.16644 11.6683C6.18377 11.8045 5.90181 12.5083 5.9309 12.6646C5.95999 12.8209 5.50921 13.1562 5.59044 13.1618Z" fill="url(&quot;#path1712223129&quot;)"></path>
                    <path d="M10.2623 21.3527C10.2608 21.6033 9.96953 21.4386 9.5038 21.069C9.27896 20.8822 9.08547 20.6546 8.9289 20.3929C8.89312 20.2027 8.87636 20.0043 8.87891 19.8012C9.11645 19.263 9.40506 18.7456 9.73867 18.2598C9.95653 17.9027 10.2365 17.5917 10.556 17.3519C11.1636 16.8554 11.7965 16.4088 12.4485 16.0167C12.5987 15.9293 12.7576 15.8776 12.9135 15.8655C13.4296 15.8129 13.9529 15.6423 14.452 15.3641C14.5363 15.3217 14.6198 15.3179 14.6963 15.1689C14.7728 15.0198 16.2368 14.4844 16.4152 14.6028C16.5936 14.7211 16.8535 14.7391 17.0585 14.8496L17.6677 15.1713C17.7246 15.1752 17.7895 15.1797 17.8254 15.3075C17.8414 15.4992 17.9715 15.6296 18.1457 15.6285C18.4822 15.6592 18.7403 15.8974 18.8234 16.2538C18.8347 16.4167 18.7935 16.5911 18.7068 16.7472C18.6045 16.8655 18.6373 17.0414 18.6036 17.1837C18.5945 17.2376 18.5818 17.2915 18.5655 17.345C18.5498 17.4114 17.5064 18.3327 17.4302 18.3756L17.2246 18.4771L16.7836 18.736C16.464 18.9358 16.1505 19.0395 16.0838 19.112C16.0171 19.1846 15.9538 19.1031 15.8726 19.0975C15.5522 19.2427 15.2366 19.411 14.9279 19.6013C14.7411 19.5884 14.5817 19.8088 14.3593 19.562C14.3025 19.5581 14.2781 19.5564 14.2456 19.5542C13.9241 19.7025 13.5963 19.8125 13.2682 19.8822C13.1056 19.952 12.9475 20.0449 12.7984 20.1583C12.7984 20.1583 12.7253 20.1533 12.6928 20.151C12.6603 20.1488 12.6035 20.1449 12.571 20.1426C12.2171 20.4172 11.7809 20.551 11.4977 20.9461C11.4287 21.0281 10.8937 21.1262 10.8239 21.2468C10.7541 21.3673 10.2729 21.2377 10.2623 21.3527Z" fill="url(&quot;#path1712223129&quot;)"></path>
                    <defs>
                        <linearGradient id="path1712223129" x1="5.50381" y1="4.15071" x2="-0.0872038" y2="21.4371" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#B9D300"></stop>
                            <stop offset="0.525" stop-color="#DBE87D"></stop>
                            <stop offset="1" stop-color="#E6EFA4"></stop>
                        </linearGradient>
                        <linearGradient id="path1712223129" x1="13.042" y1="16.2145" x2="11.8201" y2="26.009" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#B9D300"></stop>
                            <stop offset="0.525" stop-color="#DBE87D"></stop>
                            <stop offset="1" stop-color="#E6EFA4"></stop>
                        </linearGradient>
                        <linearGradient id="path1712223129" x1="-21.0001" y1="15" x2="24.7247" y2="-70.672" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#B9D300"></stop>
                            <stop offset="0.525" stop-color="#DBE87D"></stop>
                            <stop offset="1" stop-color="#E6EFA4"></stop>
                        </linearGradient>
                        <linearGradient id="path1712223129" x1="-21.0001" y1="15" x2="24.7247" y2="-70.672" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#B9D300"></stop>
                            <stop offset="0.525" stop-color="#DBE87D"></stop>
                            <stop offset="1" stop-color="#E6EFA4"></stop>
                        </linearGradient>
                    </defs>
                </svg>
                <h1 style="color: <?php echo $settings['color']; ?> !important;">
                    <?php echo $settings['text']; ?>
                </h1>
            </span>
        </div>
<?php



    }
}
