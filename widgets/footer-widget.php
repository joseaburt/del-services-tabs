<?php
/*
 * Widget Name:       Delinternet footer-widget Widget
 * Description:       This is a component to render footer-widget
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 */

namespace Delinternet\Plugins\Widgets;

use Elementor\Widget_Base;


class FooterWidget extends Widget_Base
{
    public function __construct($data = array(), $args = array())
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts()
    {
        wp_enqueue_script('del-commons-js', plugin_dir_url(__FILE__) . '../assets/js/del-commons.js');

        wp_enqueue_script('del-footer-widget-js', plugin_dir_url(__FILE__) . '../assets/js/footer-widget.js');
        wp_enqueue_style('del-footer-widget-css', plugin_dir_url(__FILE__) . '../assets/css/footer-widget.css');
    }

    public function get_name()
    {
        return 'del-footer-widget';
    }


    public function get_title()
    {
        return __('FooterWidget', 'delinternet-elementor-widgets');
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
            'services',
            [
                'label' => __('Services', 'my-elementor-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'service_group_name',
            [
                'label' => __('Service Group Name', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,

            ]
        );
        $serviceSubGroupRepeater = new \Elementor\Repeater();
        $serviceSubGroupRepeater->add_control(
            'service_name',
            [
                'label' => __('Service Name', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,

            ]
        );
        $repeater->add_control(
            'service_sub_group',
            [
                'label' => __('Service Sub Groups', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $serviceSubGroupRepeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ service_name }}}',
            ]
        );
        $this->add_control(
            'services_groups',
            [
                'label' => __('Services Groups', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ service_group_name }}}',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'contact',
            [
                'label' => __('Contact Information', 'my-elementor-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'contact_address',
            [
                'label' => __('Address', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,

            ]
        );
        $this->add_control(
            'contact_phone_number',
            [
                'label' => __('Phone Number', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,

            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'subscribe',
            [
                'label' => __('Subscription Information', 'my-elementor-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'subscrition_description',
            [
                'label' => __('Description', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,

            ]
        );
        $socialMediaRepeater = new \Elementor\Repeater();
        $socialMediaRepeater->add_control(
            'social_media_icon',
            [
                'label' => __('Icon', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::CODE,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,
                'language' => 'html',
                'rows' => 20,
            ]
        );
        $socialMediaRepeater->add_control(
            'social_media_url',
            [
                'label' => __('Url', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'plugin-domain'),
                'label_block' => true,

            ]
        );
        $this->add_control(
            'social_media_list',
            [
                'label' => __('Social Media List', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $socialMediaRepeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ social_media_url }}}',
            ]
        );
        $this->end_controls_section();
    }

    private function subcribeForm($subscrition_description, $social_media_list)
    {
?>
        <div class="footer-social-medias-container">
            <div>
                <h6>
                    Boletines
                </h6>
                <p>
                    <?php echo $subscrition_description; ?>
                </p>
            </div>
            <form>
                <div class="email-input-control">
                    <input type="email" name="" id="" placeholder="Insert Email">
                    <input type="submit" id="subscribe-footer-btn" value="Subscribir" />
                </div>
            </form>
            <hr>
            <div class="footer-social-medias">
                <?php foreach ($social_media_list as $social_media) : ?>
                    <a href="<?php echo $social_media['social_media_url']; ?>" target="__blank">
                        <?php echo $social_media['social_media_icon']; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

    <?php
    }



    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $services_groups = $settings['services_groups'];
        $contact_address = $settings['contact_address'];
        $contact_phone_number = $settings['contact_phone_number'];
        $subscrition_description = $settings['subscrition_description'];
        $social_media_list = $settings['social_media_list'];

    ?>
        <div class="del-footer-widget" id="del-footer-widget-id">
            <ul class="del-footer-services-container">
                <?php foreach ($services_groups as $group) : ?>
                    <li>
                        <h6>
                            <?php echo $group['service_group_name']; ?>
                        </h6>
                        <ul>
                            <?php foreach ($group['service_sub_group'] as $service_sub_group) : ?>
                                <li>
                                    <a href="#">
                                        <?php echo $service_sub_group['service_name']; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
            <ul class="del-footer-address-container">
                <li>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <h6>Contácta</h5>
                            <ul>
                                <li style="display: flex; gap: 10px;">
                                    <?php echo $contact_address; ?>
                                </li>
                                <li style="display: flex; gap: 10px;">
                                    <?php echo $contact_phone_number; ?>
                                </li>
                            </ul>
                    </div>
                </li>

            </ul>
            <?php $this->subcribeForm($subscrition_description, $social_media_list); ?>
            <!--  -->
        </div>
<?php
    }
}
