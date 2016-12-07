<?php

namespace SwiftPointeNamespace;
if (!defined('ABSPATH')) exit;

class SwiftPointePrintButtonAdmin
{
    private $options;

    function __construct()
    {
        add_action('admin_menu', array($this, 'menu'));
        add_action('admin_init', array($this, 'init'));
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
        add_action('save_post', array($this, 'save_post'), 1, 2);
        add_action('wp_ajax_swp_print_button_update_options', array($this, 'update_options'));
        $this->options = get_option('swp_print_button_options', false);
    }

    function init()
    {
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue'));
    }

    function menu()
    {

        add_menu_page('SwiftPointe Swift Print Admin',
            'Swift Print', 'manage_options',
            'swiftpointe-print-button', array($this, 'setting_view'), SWPPRINTURL . 'assets/icons/swift-icon.png');
    }

    function setting_view()
    {
        global $options;
        $options = $this->options;
        require_once(SWPPRINTPATH . 'tpl/settings-view.php');

    }

    function add_meta_box()
    {
        $enabled_post_types = $this->options['general']['enabled_post_types'];
        if (!empty($enabled_post_types)) {
            add_meta_box('swp_print_mb', 'Print Button', array($this, 'print_mb'), $enabled_post_types, 'side', 'high');
        }
    }

    function print_mb()
    {
        global $post;
        $swp_disable_print_btn = get_post_meta($post->ID, 'swp_disable_print_btn', true);
        if (!empty($swp_disable_print_btn) && $swp_disable_print_btn == 1)
            echo '<label class="unselectable"><input type="checkbox" name="swp_disable_print_btn" checked="checked" value="1" /> (' . $swp_disable_print_btn . ')Disable Print Button</label>';
        else
            echo '<label class="unselectable"><input type="checkbox" name="swp_disable_print_btn" value="1" /> (' . $swp_disable_print_btn . ')Disable Print Button</label>';
    }

    function admin_enqueue()
    {
        wp_enqueue_script('swp-colorpicker', plugin_dir_url(__FILE__) . 'assets/js/colorpicker.js', array('jquery'), (SWPDEBUG) ? time() : null, true);
        wp_enqueue_script('swp-on-off-switch', plugin_dir_url(__FILE__) . 'assets/js/on-off-switch.js', array('jquery'), (SWPDEBUG) ? time() : null, true);
        wp_enqueue_script('on-off-switch-onload', plugin_dir_url(__FILE__) . 'assets/js/on-off-switch-onload.js', array('swp-on-off-switch'), (SWPDEBUG) ? time() : null, true);
        wp_enqueue_script('print-button-admin', plugin_dir_url(__FILE__) . 'assets/js/swiftpointe-admin.js', array('jquery', 'jquery-form', 'swp-colorpicker', 'swp-on-off-switch', 'on-off-switch-onload'), (SWPDEBUG) ? time() : null, true);
        wp_enqueue_style('swp-colorpicker', plugin_dir_url(__FILE__) . 'assets/css/colorpicker.css', (SWPDEBUG) ? time() : null);
        wp_enqueue_style('swp-on-off-switch', plugin_dir_url(__FILE__) . 'assets/css/on-off-switch.css', (SWPDEBUG) ? time() : null);
        wp_enqueue_style('print-button-admin', plugin_dir_url(__FILE__) . 'assets/css/admin.css', (SWPDEBUG) ? time() : null);
    }

    function save_post($post_id, $post)
    {

        $enabled_post_types = $this->options['general']['enabled_post_types'];

        if (in_array($post->post_type, $enabled_post_types)) {

            if (isset($_POST['swp_disable_print_btn'])) {
                update_post_meta($post_id, 'swp_disable_print_btn', true);
            } else {
                update_post_meta($post_id, 'swp_disable_print_btn', false);
            }
        }

    }

    function update_options()
    {
        if (!current_user_can('manage_options')) {
            wp_send_json_error();
            wp_die();
        }
        $swp_enabled_post_types = isset($_POST['swp_enabled_post_types']) ? array_keys($_POST['swp_enabled_post_types']) : array();
        $swp_print_post_date = isset($_POST['swp_print_post_date']) ? true : false;
        $swp_print_modified_date = isset($_POST['swp_print_modified_date']) ? true : false;
        $swp_print_post_title = isset($_POST['swp_print_post_title']) ? true : false;
        $swp_print_post_images = isset($_POST['swp_print_post_images']) ? true : false;
        $swp_print_header = isset($_POST['swp_print_header']) ? true : false;
        $swp_print_footer = isset($_POST['swp_print_footer']) ? true : false;
        $swp_button_position = $_POST['swp_button_position'];
        $swp_page_margin_top = $_POST['swp_page_margin_top'];
        $swp_page_margin_bottom = $_POST['swp_page_margin_bottom'];
        $swp_page_margin_left = $_POST['swp_page_margin_left'];
        $swp_page_margin_right = $_POST['swp_page_margin_right'];
        $swp_button_icon = $_POST['swp_button_icon'];
        $swp_button_text = $_POST['swp_button_text'];
        $swp_button_text_size = $_POST['swp_button_text_size'];
        $swp_button_bold = isset($_POST['swp_button_bold']) ? true : false;
        $swp_button_bg_color = $_POST['swp_button_bg_color'];
        $swp_print_header_html = $_POST['swp_print_header_html'];
        $swp_print_footer_html = $_POST['swp_print_footer_html'];
        $swp_checked_roles = isset($_POST['swp_checked_roles']) ? array_keys($_POST['swp_checked_roles']) : array();

        $newOptions = array(
            'general' => array(
                'enabled_post_types' => $swp_enabled_post_types,
                'print_post_date' => $swp_print_post_date,
                'print_modified_date' => $swp_print_modified_date,
                'print_post_title' => $swp_print_post_title,
                'print_post_images' => $swp_print_post_images,
                'print_header' => $swp_print_header,
                'print_footer' => $swp_print_footer,
                'button_position' => $swp_button_position,
                'page_margin_top' => $swp_page_margin_top,
                'page_margin_bottom' => $swp_page_margin_bottom,
                'page_margin_left' => $swp_page_margin_left,
                'page_margin_right' => $swp_page_margin_right,
                'button_icon' => $swp_button_icon,
                'button_text' => $swp_button_text,
                'button_text_size' => $swp_button_text_size,
                'button_bold' => $swp_button_bold,
                'button_bg_color' => $swp_button_bg_color

            ),
            'header_html' => $swp_print_header_html,
            'footer_html' => $swp_print_footer_html,
            'print_permissions' => $swp_checked_roles,
        );

        $x = update_option('swp_print_button_options', $newOptions);

        wp_send_json(array(
            'success' => $x,
            'data' => $newOptions,
            'post' => $_POST
        ));
    }
}
