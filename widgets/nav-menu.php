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

    public function __construct($data = array(), $args = array())
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts()
    {
        wp_enqueue_script('del-commons-js', plugin_dir_url(__FILE__) . '../assets/js/del-commons.js');

        wp_enqueue_script('delinternet-menu-js', plugin_dir_url(__FILE__) . '../assets/js/menu.js');
        wp_enqueue_style('global-modal-css', plugin_dir_url(__FILE__) . '../assets/css/global-modal.css');
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

    private function navBarList($menu, $className = "main-del-menu-ul-container")
    {

        $url = get_permalink();





?>
        <ul class="<?php echo $className; ?>">
            <?php foreach ($menu as $item) : ?>
                <li class="main-del-menu-il<?php echo empty($item['subMenu']) ? '' : ' with-submenu-main-del-menu-il'; ?>">
                    <?php if (empty($item['subMenu'])) : ?>
                        <div style="display: flex; justify-content: start; gap: 5px; align-items: center;">
                            <?php if ($className != "main-del-menu-ul-container") : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--e-global-color-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                                    <path d="M5 12h14" />
                                    <path d="M12 5v14" />
                                </svg>
                            <?php endif; ?>
                            <a class="menu-anchor" href="<?php echo $item['url']; ?>" style="color: <?php echo strstr($url, $item['url']) ? 'var(--e-global-color-primary)' : '' ?> !important;">
                                <?php echo $item['title']; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($item['subMenu'])) : ?>
                        <div style="display: flex; justify-content: start; gap: 5px; align-items: center;">
                            <?php if ($className != "main-del-menu-ul-container") : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--e-global-color-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                                    <path d="M5 12h14" />
                                    <path d="M12 5v14" />
                                </svg>
                            <?php endif; ?>
                            <p class="menu-anchor">
                                <?php echo $item['title']; ?>
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </div>
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
    <?php
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $menu = $settings['list'];
        $logo = $settings['image'];
        $contactPhone = $settings['contactPhone'];
        $shallWeCallYouBtnText = $settings['shallWeCallYouBtnText'];




    ?>

        <div class="delinternet-man-navbar" id="delinternet-man-navbar-id">
            <div class="global-model">
                <style>
                    #global-model-container {
                        width: 100vw !important;
                        height: 100vh !important;
                        background-color: #00000080;
                        display: none;
                        justify-content: center;
                        align-items: center;
                        position: fixed;
                        left: 0 !important;
                        top: 0 !important;
                        backdrop-filter: blur(6px);
                        filter: blur(0px);
                        overflow: hidden;
                        z-index: 100;
                    }


                    #global-model-container>.global-model-card {
                        max-height: 90vh;
                        max-width: 800px;
                        width: 50vw;
                    }

                    #global-model-container>.global-model-card .global-modal-card-header button {
                        background-color: transparent !important;
                        color: var(--e-global-color-text) !important;
                    }
                </style>
                <div id="global-model-container" class="hidden">
                    <div class="bg-white  rounded-lg global-model-card shadow-sm">
                        <div class="global-modal-card-header px-8 pt-8 flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-slate-950">
                                    Orden de servicio o paquete
                                </h4>
                                <p class="text-slate-300">
                                    El equipo Delinternet está a tu lado para elegir el servicio más adecuado
                                </p>
                            </div>
                            <button class="bg-transparent text-slate-950 p-2" id="close-model-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-slate-950">
                                    <path d="M18 6 6 18" />
                                    <path d="m6 6 12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="global-model-card-body p-8 grid grid-cols-12 gap-4">
                            <div class="col-span-6 border rounded-xl p-8 flex flex-col gap-2">
                                <div class="flex flex-col gap-6 justify-center items-center">
                                    <h3 class="font-medium text-xl">Te llamamos</h3>
                                    <p>
                                        Déjanos tu número de móvil y nos comunicaremos contigo enseguida.
                                    </p>
                                </div>
                                <form action="" class="flex flex-col gap-4">
                                    <input placeholder="Nombre" type="text" name="" id="" class="rounded-md bg-gray-50 p-3" style="border-radius: 8px; background-color: #e3e3e3">
                                    <input type="tel" name="" placeholder="Móvil" id="" class="rounded-md bg-gray-50 p-3" style="border-radius: 8px; background-color: #e3e3e3;">
                                    <label>
                                        <input type="checkbox" name="" id="">
                                        Acepto legalidad y proteccion de datos
                                    </label>
                                    <br>
                                    <input type="submit" value="Te llamamos" style="border-radius: 4rem;">
                                </form>
                            </div>
                            <div class="col-span-6 border rounded-xl p-8 flex flex-col justify-between items-center">
                                <div class="flex flex-col gap-6 justify-center items-center">
                                    <h3 class="font-medium text-xl">Llamanos</h3>
                                    <p class="text-center">
                                        Nuestro horario de atención al usuario es de lunes a sábado en horario comercial, fuera de horario nos puedes dejar un mensaje en el contestador y lo atenderemos tan pronto como nos sea posible.
                                    </p>
                                </div>
                                <a style="width: 100%; border: 1px solid var(--e-global-color-primary); border-radius: 4rem; padding: 14px 32px; text-align: center;" class="call-us-anchor menu-anchor" href="tel:<?php echo preg_replace('/\s+/', '', $contactPhone); ?>">
                                    Llamanos <b><?php echo $contactPhone; ?></b>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="elementor-element e-con-boxed e-con">
                <div class="e-con-inner main-del-navbar">
                    <div class="main-del-menu-ul-container-xs-container" id="main-del-menu-ul-container-xs-container-id">
                        <div class="inner-container">
                            <div style="margin-bottom: 1rem; display: flex; align-items: center; justify-content: space-between;">
                                <a href="/" class="logo-anchor">
                                    <img class="logo-img" src="<?php echo $logo["url"]; ?>" alt="<?php echo $logo["alt"]; ?>">
                                </a>
                                <button class="shall-we-call-you-icon-button-xs-header" id="shall-we-call-you-text-button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.45 22.75C16.32 22.75 15.13 22.48 13.9 21.96C12.7 21.45 11.49 20.75 10.31 19.9C9.14 19.04 8.01 18.08 6.94 17.03C5.88 15.96 4.92 14.83 4.07 13.67C3.21 12.47 2.52 11.27 2.03 10.11C1.51 8.87 1.25 7.67 1.25 6.54C1.25 5.76 1.39 5.02 1.66 4.33C1.94 3.62 2.39 2.96 3 2.39C3.77 1.63 4.65 1.25 5.59 1.25C5.98 1.25 6.38 1.34 6.72 1.5C7.11 1.68 7.44 1.95 7.68 2.31L10 5.58C10.21 5.87 10.37 6.15 10.48 6.43C10.61 6.73 10.68 7.03 10.68 7.32C10.68 7.7 10.57 8.07 10.36 8.42C10.21 8.69 9.98 8.98 9.69 9.27L9.01 9.98C9.02 10.01 9.03 10.03 9.04 10.05C9.16 10.26 9.4 10.62 9.86 11.16C10.35 11.72 10.81 12.23 11.27 12.7C11.86 13.28 12.35 13.74 12.81 14.12C13.38 14.6 13.75 14.84 13.97 14.95L13.95 15L14.68 14.28C14.99 13.97 15.29 13.74 15.58 13.59C16.13 13.25 16.83 13.19 17.53 13.48C17.79 13.59 18.07 13.74 18.37 13.95L21.69 16.31C22.06 16.56 22.33 16.88 22.49 17.26C22.64 17.64 22.71 17.99 22.71 18.34C22.71 18.82 22.6 19.3 22.39 19.75C22.18 20.2 21.92 20.59 21.59 20.95C21.02 21.58 20.4 22.03 19.68 22.32C18.99 22.6 18.24 22.75 17.45 22.75ZM5.59 2.75C5.04 2.75 4.53 2.99 4.04 3.47C3.58 3.9 3.26 4.37 3.06 4.88C2.85 5.4 2.75 5.95 2.75 6.54C2.75 7.47 2.97 8.48 3.41 9.52C3.86 10.58 4.49 11.68 5.29 12.78C6.09 13.88 7 14.95 8 15.96C9 16.95 10.08 17.87 11.19 18.68C12.27 19.47 13.38 20.11 14.48 20.57C16.19 21.3 17.79 21.47 19.11 20.92C19.62 20.71 20.07 20.39 20.48 19.93C20.71 19.68 20.89 19.41 21.04 19.09C21.16 18.84 21.22 18.58 21.22 18.32C21.22 18.16 21.19 18 21.11 17.82C21.08 17.76 21.02 17.65 20.83 17.52L17.51 15.16C17.31 15.02 17.13 14.92 16.96 14.85C16.74 14.76 16.65 14.67 16.31 14.88C16.11 14.98 15.93 15.13 15.73 15.33L14.97 16.08C14.58 16.46 13.98 16.55 13.52 16.38L13.25 16.26C12.84 16.04 12.36 15.7 11.83 15.25C11.35 14.84 10.83 14.36 10.2 13.74C9.71 13.24 9.22 12.71 8.71 12.12C8.24 11.57 7.9 11.1 7.69 10.71L7.57 10.41C7.51 10.18 7.49 10.05 7.49 9.91C7.49 9.55 7.62 9.23 7.87 8.98L8.62 8.2C8.82 8 8.97 7.81 9.07 7.64C9.15 7.51 9.18 7.4 9.18 7.3C9.18 7.22 9.15 7.1 9.1 6.98C9.03 6.82 8.92 6.64 8.78 6.45L6.46 3.17C6.36 3.03 6.24 2.93 6.09 2.86C5.93 2.79 5.76 2.75 5.59 2.75ZM13.95 15.01L13.79 15.69L14.06 14.99C14.01 14.98 13.97 14.99 13.95 15.01Z" fill="#37424A" />
                                        <path d="M18.5 9.75C18.09 9.75 17.75 9.41 17.75 9C17.75 8.64 17.39 7.89 16.79 7.25C16.2 6.62 15.55 6.25 15 6.25C14.59 6.25 14.25 5.91 14.25 5.5C14.25 5.09 14.59 4.75 15 4.75C15.97 4.75 16.99 5.27 17.88 6.22C18.71 7.11 19.25 8.2 19.25 9C19.25 9.41 18.91 9.75 18.5 9.75Z" fill="#37424A" />
                                        <path d="M22 9.75C21.59 9.75 21.25 9.41 21.25 9C21.25 5.55 18.45 2.75 15 2.75C14.59 2.75 14.25 2.41 14.25 2C14.25 1.59 14.59 1.25 15 1.25C19.27 1.25 22.75 4.73 22.75 9C22.75 9.41 22.41 9.75 22 9.75Z" fill="#37424A" />
                                    </svg>
                                </button>
                            </div>
                            <?php $this->navBarList($menu, "main-del-menu-ul-container-xs"); ?>
                        </div>
                        <div style="background-color: transparent; width: 100%; height: 100%;" id="close-menu-container-id"></div>
                    </div>
                    <button class="shall-we-call-you-icon-button-xs" id="shall-we-call-you-text-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.45 22.75C16.32 22.75 15.13 22.48 13.9 21.96C12.7 21.45 11.49 20.75 10.31 19.9C9.14 19.04 8.01 18.08 6.94 17.03C5.88 15.96 4.92 14.83 4.07 13.67C3.21 12.47 2.52 11.27 2.03 10.11C1.51 8.87 1.25 7.67 1.25 6.54C1.25 5.76 1.39 5.02 1.66 4.33C1.94 3.62 2.39 2.96 3 2.39C3.77 1.63 4.65 1.25 5.59 1.25C5.98 1.25 6.38 1.34 6.72 1.5C7.11 1.68 7.44 1.95 7.68 2.31L10 5.58C10.21 5.87 10.37 6.15 10.48 6.43C10.61 6.73 10.68 7.03 10.68 7.32C10.68 7.7 10.57 8.07 10.36 8.42C10.21 8.69 9.98 8.98 9.69 9.27L9.01 9.98C9.02 10.01 9.03 10.03 9.04 10.05C9.16 10.26 9.4 10.62 9.86 11.16C10.35 11.72 10.81 12.23 11.27 12.7C11.86 13.28 12.35 13.74 12.81 14.12C13.38 14.6 13.75 14.84 13.97 14.95L13.95 15L14.68 14.28C14.99 13.97 15.29 13.74 15.58 13.59C16.13 13.25 16.83 13.19 17.53 13.48C17.79 13.59 18.07 13.74 18.37 13.95L21.69 16.31C22.06 16.56 22.33 16.88 22.49 17.26C22.64 17.64 22.71 17.99 22.71 18.34C22.71 18.82 22.6 19.3 22.39 19.75C22.18 20.2 21.92 20.59 21.59 20.95C21.02 21.58 20.4 22.03 19.68 22.32C18.99 22.6 18.24 22.75 17.45 22.75ZM5.59 2.75C5.04 2.75 4.53 2.99 4.04 3.47C3.58 3.9 3.26 4.37 3.06 4.88C2.85 5.4 2.75 5.95 2.75 6.54C2.75 7.47 2.97 8.48 3.41 9.52C3.86 10.58 4.49 11.68 5.29 12.78C6.09 13.88 7 14.95 8 15.96C9 16.95 10.08 17.87 11.19 18.68C12.27 19.47 13.38 20.11 14.48 20.57C16.19 21.3 17.79 21.47 19.11 20.92C19.62 20.71 20.07 20.39 20.48 19.93C20.71 19.68 20.89 19.41 21.04 19.09C21.16 18.84 21.22 18.58 21.22 18.32C21.22 18.16 21.19 18 21.11 17.82C21.08 17.76 21.02 17.65 20.83 17.52L17.51 15.16C17.31 15.02 17.13 14.92 16.96 14.85C16.74 14.76 16.65 14.67 16.31 14.88C16.11 14.98 15.93 15.13 15.73 15.33L14.97 16.08C14.58 16.46 13.98 16.55 13.52 16.38L13.25 16.26C12.84 16.04 12.36 15.7 11.83 15.25C11.35 14.84 10.83 14.36 10.2 13.74C9.71 13.24 9.22 12.71 8.71 12.12C8.24 11.57 7.9 11.1 7.69 10.71L7.57 10.41C7.51 10.18 7.49 10.05 7.49 9.91C7.49 9.55 7.62 9.23 7.87 8.98L8.62 8.2C8.82 8 8.97 7.81 9.07 7.64C9.15 7.51 9.18 7.4 9.18 7.3C9.18 7.22 9.15 7.1 9.1 6.98C9.03 6.82 8.92 6.64 8.78 6.45L6.46 3.17C6.36 3.03 6.24 2.93 6.09 2.86C5.93 2.79 5.76 2.75 5.59 2.75ZM13.95 15.01L13.79 15.69L14.06 14.99C14.01 14.98 13.97 14.99 13.95 15.01Z" fill="#37424A" />
                            <path d="M18.5 9.75C18.09 9.75 17.75 9.41 17.75 9C17.75 8.64 17.39 7.89 16.79 7.25C16.2 6.62 15.55 6.25 15 6.25C14.59 6.25 14.25 5.91 14.25 5.5C14.25 5.09 14.59 4.75 15 4.75C15.97 4.75 16.99 5.27 17.88 6.22C18.71 7.11 19.25 8.2 19.25 9C19.25 9.41 18.91 9.75 18.5 9.75Z" fill="#37424A" />
                            <path d="M22 9.75C21.59 9.75 21.25 9.41 21.25 9C21.25 5.55 18.45 2.75 15 2.75C14.59 2.75 14.25 2.41 14.25 2C14.25 1.59 14.59 1.25 15 1.25C19.27 1.25 22.75 4.73 22.75 9C22.75 9.41 22.41 9.75 22 9.75Z" fill="#37424A" />
                        </svg>
                    </button>
                    <div class="left-side">
                        <a href="/" class="logo-anchor">
                            <img class="logo-img" src="<?php echo $logo["url"]; ?>" alt="<?php echo $logo["alt"]; ?>">
                        </a>
                        <?php $this->navBarList($menu); ?>
                    </div>
                    <a href="/" class="logo-anchor-sx">
                        <img class="logo-img" src="<?php echo $logo["url"]; ?>" alt="<?php echo $logo["alt"]; ?>">
                    </a>
                    <div class="right-side">
                        <button style="display: none;" class="responsive-menu-icon-button" id="responsive-menu-icon-button-id">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu">
                                <line x1="4" x2="20" y1="12" y2="12" />
                                <line x1="4" x2="20" y1="6" y2="6" />
                                <line x1="4" x2="20" y1="18" y2="18" />
                            </svg>
                        </button>
                        <a class="call-us-anchor menu-anchor" href="tel:<?php echo preg_replace('/\s+/', '', $contactPhone); ?>">
                            Llama: <b><?php echo $contactPhone; ?></b>
                        </a>
                        <button class="shall-we-call-you-text-button" id="shall-we-call-you-text-button">
                            <?php echo $shallWeCallYouBtnText; ?>
                        </button>
                        <button class="shall-we-call-you-icon-button">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.45 22.75C16.32 22.75 15.13 22.48 13.9 21.96C12.7 21.45 11.49 20.75 10.31 19.9C9.14 19.04 8.01 18.08 6.94 17.03C5.88 15.96 4.92 14.83 4.07 13.67C3.21 12.47 2.52 11.27 2.03 10.11C1.51 8.87 1.25 7.67 1.25 6.54C1.25 5.76 1.39 5.02 1.66 4.33C1.94 3.62 2.39 2.96 3 2.39C3.77 1.63 4.65 1.25 5.59 1.25C5.98 1.25 6.38 1.34 6.72 1.5C7.11 1.68 7.44 1.95 7.68 2.31L10 5.58C10.21 5.87 10.37 6.15 10.48 6.43C10.61 6.73 10.68 7.03 10.68 7.32C10.68 7.7 10.57 8.07 10.36 8.42C10.21 8.69 9.98 8.98 9.69 9.27L9.01 9.98C9.02 10.01 9.03 10.03 9.04 10.05C9.16 10.26 9.4 10.62 9.86 11.16C10.35 11.72 10.81 12.23 11.27 12.7C11.86 13.28 12.35 13.74 12.81 14.12C13.38 14.6 13.75 14.84 13.97 14.95L13.95 15L14.68 14.28C14.99 13.97 15.29 13.74 15.58 13.59C16.13 13.25 16.83 13.19 17.53 13.48C17.79 13.59 18.07 13.74 18.37 13.95L21.69 16.31C22.06 16.56 22.33 16.88 22.49 17.26C22.64 17.64 22.71 17.99 22.71 18.34C22.71 18.82 22.6 19.3 22.39 19.75C22.18 20.2 21.92 20.59 21.59 20.95C21.02 21.58 20.4 22.03 19.68 22.32C18.99 22.6 18.24 22.75 17.45 22.75ZM5.59 2.75C5.04 2.75 4.53 2.99 4.04 3.47C3.58 3.9 3.26 4.37 3.06 4.88C2.85 5.4 2.75 5.95 2.75 6.54C2.75 7.47 2.97 8.48 3.41 9.52C3.86 10.58 4.49 11.68 5.29 12.78C6.09 13.88 7 14.95 8 15.96C9 16.95 10.08 17.87 11.19 18.68C12.27 19.47 13.38 20.11 14.48 20.57C16.19 21.3 17.79 21.47 19.11 20.92C19.62 20.71 20.07 20.39 20.48 19.93C20.71 19.68 20.89 19.41 21.04 19.09C21.16 18.84 21.22 18.58 21.22 18.32C21.22 18.16 21.19 18 21.11 17.82C21.08 17.76 21.02 17.65 20.83 17.52L17.51 15.16C17.31 15.02 17.13 14.92 16.96 14.85C16.74 14.76 16.65 14.67 16.31 14.88C16.11 14.98 15.93 15.13 15.73 15.33L14.97 16.08C14.58 16.46 13.98 16.55 13.52 16.38L13.25 16.26C12.84 16.04 12.36 15.7 11.83 15.25C11.35 14.84 10.83 14.36 10.2 13.74C9.71 13.24 9.22 12.71 8.71 12.12C8.24 11.57 7.9 11.1 7.69 10.71L7.57 10.41C7.51 10.18 7.49 10.05 7.49 9.91C7.49 9.55 7.62 9.23 7.87 8.98L8.62 8.2C8.82 8 8.97 7.81 9.07 7.64C9.15 7.51 9.18 7.4 9.18 7.3C9.18 7.22 9.15 7.1 9.1 6.98C9.03 6.82 8.92 6.64 8.78 6.45L6.46 3.17C6.36 3.03 6.24 2.93 6.09 2.86C5.93 2.79 5.76 2.75 5.59 2.75ZM13.95 15.01L13.79 15.69L14.06 14.99C14.01 14.98 13.97 14.99 13.95 15.01Z" fill="#37424A" />
                                <path d="M18.5 9.75C18.09 9.75 17.75 9.41 17.75 9C17.75 8.64 17.39 7.89 16.79 7.25C16.2 6.62 15.55 6.25 15 6.25C14.59 6.25 14.25 5.91 14.25 5.5C14.25 5.09 14.59 4.75 15 4.75C15.97 4.75 16.99 5.27 17.88 6.22C18.71 7.11 19.25 8.2 19.25 9C19.25 9.41 18.91 9.75 18.5 9.75Z" fill="#37424A" />
                                <path d="M22 9.75C21.59 9.75 21.25 9.41 21.25 9C21.25 5.55 18.45 2.75 15 2.75C14.59 2.75 14.25 2.41 14.25 2C14.25 1.59 14.59 1.25 15 1.25C19.27 1.25 22.75 4.73 22.75 9C22.75 9.41 22.41 9.75 22 9.75Z" fill="#37424A" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
