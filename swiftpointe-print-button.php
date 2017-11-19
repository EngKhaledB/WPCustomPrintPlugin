<?php
/*
Plugin Name: SwiftPointe Print Button
Description: Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
Version: 1.0
Author: Khaled B. Abu Alqomboz ( eng.khaledb@gmail.com )
*/

namespace SwiftPointeNamespace;
if (!defined('ABSPATH')) exit;

define('SWPPRINTPATH', plugin_dir_path(__FILE__));
define('SWPPRINTURL', plugin_dir_url(__FILE__));
define('SWPDEBUG', false);

register_uninstall_hook(__FILE__, 'swiftpointe_print_uninstall');
function swiftpointe_print_uninstall()
{
    delete_option('swp_print_button_options');
}

require_once('swiftpointe-print-button-admin.php');

class SwiftPointePrintButton
{
    function __construct()
    {
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        add_action('init', array($this, 'init'));

    }

    function activate()
    {
        $options = get_option('swp_print_button_options', false);
        if (!$options) {
            $options = array(
                'general' => array(
                    'enabled_post_types' => array(),
                    'print_post_date' => true,
                    'print_modified_date' => true,
                    'print_post_title' => true,
                    'print_post_images' => true,
                    'print_header' => true,
                    'print_footer' => true,
                    'button_position' => 'top',
                    'page_margin_top' => 20,
                    'page_margin_bottom' => 20,
                    'page_margin_left' => 20,
                    'page_margin_right' => 20,
                    'button_icon' => 'icon1',
                    'button_text' => 'Print',
                    'button_text_size' => '12px',
                    'button_bold' => true,
                    'button_bg_color' => '#cc1414'

                ),
                'header_html' => '',
                'footer_html' => '',
                'print_permissions' => array()
            );

            add_option('swp_print_button_options', $options, '', true);
        }

        add_rewrite_endpoint('print', EP_ALL);
        global $wp_rewrite;
        $wp_rewrite->flush_rules(false);
    }

    function deactivate()
    {
        delete_option('swp_print_button_options');
    }


    function init()
    {
        add_action('wp_enqueue_scripts', array($this, 'front_enqueue'));
        add_rewrite_endpoint('print', EP_ALL);

        $options = get_option('swp_print_button_options', false);

        add_action('template_redirect', function () use ($options) {
            if (is_user_logged_in() && is_singular()) {
                global $post;
                global $current_user;
                $intersect = array_intersect($current_user->roles, $options['print_permissions']);

                if (in_array($post->post_type, $options['general']['enabled_post_types']) && !empty($intersect)) {
                    $disable_option = get_post_meta($post->ID, 'swp_disable_print_btn', true);
                    if (empty($disable_option) || (bool)$disable_option == false) {
                        global $wp_query;
                        if (isset($wp_query->query_vars['print'])) {
                            add_filter('template_include', function () {
                                return SWPPRINTPATH . 'tpl/print-view.php';
                            });
                        } else {
                            add_filter('the_content', function ($content) use ($options) {
                                return $this->print_button_html($content, $options);
                            });
                        }

                    }
                }
            }

        });


    }

    function front_enqueue()
    {
        wp_enqueue_style('print-button-front', plugin_dir_url(__FILE__) . 'assets/css/swiftpointe-front.css', (SWPDEBUG) ? time() : null);
    }

    function print_button_html($content, $options)
    {

        global $post;
        $link = get_the_permalink($post->ID);
        $position = $options['general']['button_position'];
        $button_icon = $options['general']['button_icon'];
        if ($button_icon == 'icon6') {
            $button_text = $options['general']['button_text'];
            $button_text_size = $options['general']['button_text_size'];
            $button_bold = $options['general']['button_bold'];
            $button_bg_color = $options['general']['button_bg_color'];
            $button = '<div style="width: 100%; overflow: hidden;  height: 32px;">' . sprintf('<a href="%sprint/" target="_blank" style="background: %s;text-decoration: none !important; float: right; color :#ffffff !important; border-radius: 5px;padding: 5px;font-size: %s;font-weight: %s;">%s</a></div>',
                    $link, $button_bg_color, $button_text_size, $button_bold == true ? 'bold' : 'normal', $button_text);
        } else {
            $button = '<div style="width: 100%; overflow: hidden;  height: 32px;">' . sprintf('<a href="%sprint/" style="float: right;" target="_blank"><img src="%s.png" alt=""/></a></div>', $link, SWPPRINTURL . 'assets/icons/' . $button_icon);
        }
        if ($position == 'top')
            return ($button . $content);
        else
            return ($content . $button);
    }

}

new SwiftPointePrintButton();

if (is_admin()) {
    new SwiftPointePrintButtonAdmin();
}
